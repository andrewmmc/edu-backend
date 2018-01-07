<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Payments extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // Load helpers
        $this->load->helper('url');
        $this->load->model('Courses_model');
        $this->load->model('Courses_registration_model');
        $this->load->model('Transaction_records_model');
        // Load PayPal library
        $this->config->load('paypal');
        $config = array(
            'Sandbox'               => $this->config->item('Sandbox'),
            // Sandbox / testing mode option.
            'APIUsername'           => $this->config->item('APIUsername'),
            // PayPal API username of the API caller
            'APIPassword'           => $this->config->item('APIPassword'),
            // PayPal API password of the API caller
            'APISignature'          => $this->config->item('APISignature'),
            // PayPal API signature of the API caller
            'APISubject'            => '',
            // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion'            => $this->config->item('APIVersion'),
            // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'DeviceID'              => $this->config->item('DeviceID'),
            'ApplicationID'         => $this->config->item('ApplicationID'),
            'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
        );
        if ($config['Sandbox']) {
            // Show Errors
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }
        $this->load->library('paypal/Paypal_adaptive', $config);
    }

    function Pay_chained()
    {
        // Modified for education catalog platform
        $data = $this->input->post();
        if (empty($data)) {
            echo 'missing data input';
        }
        $members_id = $data['members_id'];
        $courses_id = $data['courses_id'];
        $providers_id = $data['providers_id'];
        $course = $this->Courses_model->get_courses($data['courses_id']);

        if (empty($course)) {
            echo 'courses does not exist';
            return;
        }

        $amounts = $this->Courses_model->get_courses_price($courses_id);
        $amounts = $amounts[0]->price;
        $random_id = mt_rand();
        $ref_id = $members_id . 'C' . $courses_id . 'R' . $random_id;

        $transaction_id = $this->Transaction_records_model->insert_paypal_records($courses_id, $providers_id,
            $members_id, $amounts, $ref_id);

        // Prepare request arrays
        $PayRequestFields = array(
            'ActionType'                        => 'PAY',
            // Required.  Whether the request pays the receiver or whether the request is set up to create a payment request, but not fulfill the payment until the ExecutePayment is called.  Values are:  PAY, CREATE, PAY_PRIMARY
            'CancelURL'                         => site_url('paypal/Payments/pay_cancel/' . $transaction_id),
            // Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
            'CurrencyCode'                      => 'HKD',
            // Required.  3 character currency code.
            'FeesPayer'                         => 'EACHRECEIVER',
            // The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
            'IPNNotificationURL'                => '',
            // The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
            'Memo'                              => '',
            // A note associated with the payment (text, not HTML).  1000 char max
            'Pin'                               => '',
            // The sener's personal id number, which was specified when the sender signed up for the preapproval
            'PreapprovalKey'                    => '',
            // The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.
            'ReturnURL'                         => site_url('paypal/Payments/pay_return/' . $transaction_id),
            // Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
            'ReverseAllParallelPaymentsOnError' => '',
            // Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
            'SenderEmail'                       => '',
            // Sender's email address.  127 char max.
            'TrackingID'                        => ''
            // Unique ID that you specify to track the payment.  127 char max.
        );

        $ClientDetailsFields = array(
            'CustomerID'   => '',
            // Your ID for the sender  127 char max.
            'CustomerType' => '',
            // Your ID of the type of customer.  127 char max.
            'GeoLocation'  => '',
            // Sender's geographic location
            'Model'        => '',
            // A sub-identification of the application.  127 char max.
            'PartnerName'  => ''
            // Your organization's name or ID
        );

        $FundingTypes = array('ECHECK', 'BALANCE', 'CREDITCARD');

        $Receivers = array();
        $Receiver = array(
            'Amount'         => $amounts,
            // Required.  Amount to be paid to the receiver.
            //'Amount' => '100.00',                                            // Required.  Amount to be paid to the receiver.
            'Email'          => '12104585d@connect.polyu.hk',
            // Receiver's email address. 127 char max.
            'InvoiceID'      => $ref_id,
            // The invoice number for the payment.  127 char max.
            //'InvoiceID' => '123-ABCDEF',                                            // The invoice number for the payment.  127 char max.
            'PaymentType'    => 'SERVICE',
            // Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
            'PaymentSubType' => '',
            // The transaction subtype for the payment.
            'Phone'          => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''),
            // Receiver's phone number.   Numbers only.
            'Primary'        => 'FALSE'
            // Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
        );
        array_push($Receivers, $Receiver);


        $SenderIdentifierFields = array(
            'UseCredentials' => ''
            // If TRUE, use credentials to identify the sender.  Default is false.
        );

        $AccountIdentifierFields = array(
            'Email' => '',
            // Sender's email address.  127 char max.
            'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => '')
            // Sender's phone number.  Numbers only.
        );

        $PayPalRequestData = array(
            'PayRequestFields'        => $PayRequestFields,
            'ClientDetailsFields'     => $ClientDetailsFields,
            'FundingTypes'            => $FundingTypes,
            'Receivers'               => $Receivers,
            'SenderIdentifierFields'  => $SenderIdentifierFields,
            'AccountIdentifierFields' => $AccountIdentifierFields
        );

        $PayPalResult = $this->paypal_adaptive->Pay($PayPalRequestData);

        if (!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack'])) {
            $errors = array('Errors' => $PayPalResult['Errors']);
            $this->load->view('paypal/samples/error', $errors);
        } else {
            // Successful call.
            redirect($PayPalResult['RedirectURL']);
        }
    }

    function pay_cancel($transaction_id)
    {
        $data = $this->Transaction_records_model->get_transaction_records($transaction_id);
        redirect('http://localhost/edu-platform/#/payments/failure/' . $data[0]->courses_id);
    }

    function pay_return($transaction_id)
    {
        $this->Transaction_records_model->paypal_successful($transaction_id);
        $data = $this->Transaction_records_model->get_transaction_records($transaction_id);
        $courses_id = $data[0]->courses_id;
        $transaction_id = $data[0]->transaction_id;
        $members_id = $data[0]->members_id;
        $this->Courses_registration_model->insert_courses_registration($courses_id, $transaction_id, $members_id);
        redirect('http://localhost/edu-platform/#/payments/successful/' . $data[0]->courses_id);
    }
}