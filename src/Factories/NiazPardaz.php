<?php

namespace Sim\SMS\Factories;

use Closure;
use Sim\SMS\Abstracts\AbstractSMS;
use Sim\SMS\Exceptions\SMSException;
use Sim\SMS\MessageProvider;
use SoapClient as Soap;

class NiazPardaz extends AbstractSMS
{
    /**
     * {@inheritdoc}
     */
    protected $parameters = [
        'isFlash' => false,
    ];

    /**
     * @var array $rec_ids
     */
    protected $rec_ids = [];

    /**
     * {@inheritdoc}
     */
    protected $sms_code_message = [
        'get_credit' => [
            -1 => 'نام کاربری و رمز عبور صحیح نمی باشد',
            -2 => 'کاربر غیر فعال می‌باشد',
        ],
        'get_inbox_count' => [
            -1 => 'نام کاربری و رمز عبور صحیح نمی باشد',
        ],
        'send_sms' => [
            0 => 'ارسال با موفقیت انجام شد',
            1 => 'نام کاربر یا کلمه عبور نامعتبر است',
            2 => 'کاربر مسدود شده است',
            3 => 'شماره فرستنده نامعتبر است',
            4 => 'محدودیت در ارسال روزانه',
            5 => 'تعداد گیرندگان حداکثر ۱۰۰ شماره می‌باشد',
            6 => 'خط فرستنده غیرفعال است',
            7 => 'متن پیامک شامل کلمات فیلتر شده است',
            8 => 'اعتبار کافی نیست',
            9 => 'سامانه در حال بروزرسانی می‌باشد',
            10 => 'وب سرویس غیر فعال است',
        ],
        'send_batch_sms' => [
            0 => 'ارسال با موفقیت انجام شد',
            1 => 'نام کاربر یا کلمه عبور نامعتبر است',
            2 => 'کاربر مسدود شده است',
            3 => 'شماره فرستنده نامعتبر است',
            4 => 'محدودیت در ارسال روزانه',
            5 => 'تعداد گیرندگان حداکثر ۱۰۰ شماره می‌باشد',
            6 => 'خط فرستنده غیرفعال است',
            7 => 'متن پیامک شامل کلمات فیلتر شده است',
            8 => 'اعتبار کافی نیست',
            9 => 'سامانه در حال بروزرسانی می‌باشد',
            10 => 'وب سرویس غیر فعال است',
        ],
        'get_batch_delivery' => [
            -1 => 'نام کاربری و رمز عبور صحیح نمی‌باشد',
            -2 => 'ارسال با مقدار شناسه batchSmsId وجود ندارد',
        ],
        'get_delivery' => [
            -5 => 'برای گرفتن گزارش تحویل حداقل یک دقیقه بعد از ارسال اقدام نمایید',
            -4 => 'به علت اینکه پیام در صف ارسال مخابرات می باشد، امکان گرفتن گزارش تحویل وجود ندارد',
            -3 => 'به علت اینکه مهلت یک هفته ای گرفتن گزارش پایان یافته است، امکان گرفتن گزارش تحویل وجود ندارد',
            -2 => 'پیام با این کد وجود ندارد (batchSmsId نامعتبر است)',
            -1 => 'خطا در ارتباط با سرویس دهنده',
            0 => 'ارسال شده به مخابرات',
            1 => 'رسیده به گوشی',
            2 => 'نرسیده به گوشی',
            3 => 'خطای مخابراتی',
            4 => 'خطای نامشخص',
            5 => 'رسیده به مخابرات',
            6 => 'نرسیده به مخابرات',
            7 => 'مسدود شده توسط مقصد',
            8 => 'نامشخص',
            9 => 'مخابرات پیام را مردود اعلام کرد',
            10 => 'کنسل شده توسط اپراتور',
            11 => 'ارسال نشده',
        ],
        'number_is_in_telecom_blacklist' => [
            -1 => 'نام کاربری و رمز عبور صحیح نمی‌باشد',
            -2 => 'کاربر غیرفعال می‌باشد',
            -3 => 'شماره همراه مشخص نشده است',
            0 => 'شماره آزاد است',
            1 => 'شماره در لیست سیاه مخابرات است',
        ],
        'extract_telecom_blacklist_numbers' => [
            -1 => 'نام کاربری و رمز عبور صحیح نمی‌باشد',
            -2 => 'کاربر غیرفعال می‌باشد',
            -3 => 'آرایه‌ی شماره‌های همراه خالی می‌باشد',
            -4 => 'تعداد شماره‌ها حداکثر ۱۰۰۰ شماره می‌باشد',
            0 => 'عملیات با موفقیت انجام شد',
        ],
        'send_sms_like_to_like' => [
            0 => ' ارسال با موفقیت انجام شد',
            1 => ' نام کاربر یا کلمه عبور نامعتبر می باشد',
            2 => ' کاربر مسدود شده است',
            3 => ' شماره فرستنده نامعتبر است',
            4 => 'حدودیت در ارسال روزانه',
            5 => 'تعداد گیرندگان حداکثر 100 شماره می باشد',
            6 => ' خط فرسنتده غیرفعال است',
            7 => ' متن پیامک شامل کلمات فیلتر شده است',
            8 => ' اعتبار کافی نیست',
            9 => ' سامانه در حال بروز رسانی می باشد',
            10 => ' وب سرویس غیرفعال است',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    protected $urls = [
        'service_url' => 'http://payamak-service.ir/SendService.svc?wsdl',
    ];

    /**
     * @var Soap|null $client
     */
    protected $client = null;

    /**
     * @var string|null $username
     */
    protected $username = null;

    /**
     * @var string|null $password
     */
    protected $password = null;

    /**
     * @var string|null $from_number
     */
    protected $from_number = null;

    /**
     * NiazPardaz constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username = null, string $password = null)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $this->client = new Soap($this->urls['service_url'], array('encoding' => 'UTF-8'));

        $this->username = $username;
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function fromNumber(string $number)
    {
        $this->from_number = $number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function credit($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter(string $parameter_name, &$parameter_value)
    {
        $this->parameters[$parameter_name] = $parameter_value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter(string $parameter_name, $prefer = null)
    {
        return $this->parameters[$parameter_name] ?? $prefer;
    }

    /**
     * {@inheritdoc}
     * @throws SMSException
     */
    public function send(MessageProvider $message)
    {
        // check some functionality
        $this->checker();

        if (!empty($message->getNumbers())) {
            throw new SMSException('Please specify numbers you want send message to');
        }
        if (empty($message->getBody())) {
            throw new SMSException('The body is empty! Please add some text to it');
        }

        // define needed parameters
        $parameters = [
            'userName' => $this->getParameter('userName') ?: $this->username,
            'password' => $this->getParameter('password') ?: $this->password,
            'fromNumber' => $this->getParameter('fromNumber'),
            'messageContent' => $message->getBody(),
            'isFlash' => $this->getParameter('isFlash'),
        ];

        $allNumbers = $message->getNumbers();

        $successCount = 0;
        $tmpRecIds = [];
        $mustSlice = ceil(count($allNumbers) / 100);

        for ($i = 0; $i < $mustSlice; $i++) {
            $recId = array();
//            $status = array();

            $parameters['recId'] =  &$recId;
//            $this->_parameters['status'] = &$status;

            // Slice 100 numbers each time
            $parameters['toNumbers'] = array_slice($allNumbers, $i * 100, 100);

            // Send sms functionality
            $sendRes = $this->client->SendSMS($parameters)->SendSMSResult;

            if ($sendRes == 0) {
                $successCount++;
            }

            if ($mustSlice == 1) {
                $this->status = [
                    'code' => $sendRes,
                    'message' => $this->sms_code_message['send_sms'][$sendRes] ?? $this->unknown_message,
                ];
            } else {
                $this->status[] = [
                    'code' => $sendRes,
                    'message' => $this->sms_code_message['send_sms'][$sendRes] ?? $this->unknown_message,
                ];
            }

            $tmpRecIds = array_merge($tmpRecIds, $recId);
//            $this->_tmpSendStatus['status'] = array_merge($this->_tmpSendStatus['status'], $status);
        }

        $this->rec_ids = $tmpRecIds;

        // check if all 100 pieces of numbers sent successfully
        if ($mustSlice == $successCount) {
            $this->is_successful = true;
        } else { // call error closure
            if($this->error_callback instanceof Closure) {
                call_user_func_array($this->error_callback, [$this->status['code'], $this->status['message'], $parameters]);
            }
        }

        return $this;
    }

    /**
     * Return a number greater or equal to 0 otherwise return -1
     *
     * {@inheritdoc}
     * @throws SMSException
     */
    public function getCredit(): float
    {
        // check some functionality
        $this->checker();

        // define needed parameters
        $parameters = [
            'userName' => $this->getParameter('userName') ?: $this->username,
            'password' => $this->getParameter('password') ?: $this->password,
        ];

        // call GetCredit function
        $res = $this->client->GetCredit($parameters)->GetCreditResult;

        // there is error if we have negative result
        if ($res < 0) {
            $this->status = [
                'code' => $res,
                'message' => $this->sms_code_message['get_credit'][$res] ?? $this->unknown_message,
            ];

            // call error closure
            if ($this->error_callback instanceof Closure) {
                call_user_func_array($this->error_callback, [$this->status['code'], $this->status['message'], $parameters]);
            }

            // if error happen
            return -1;
        }

        $this->is_successful = true;

        return $res;
    }

    /**
     * Return a number greater or equal to 0 otherwise return -1
     *
     * @return int
     * @throws SMSException
     */
    public function getInboxCount(): int
    {
        // check some functionality
        $this->checker();

        // define needed parameters
        $parameters = [
            'userName' => $this->getParameter('userName') ?: $this->username,
            'password' => $this->getParameter('password') ?: $this->password,
            'isRead' => $this->getParameter('isRead'),
        ];

        // call GetInboxCount function
        $res = $this->client->GetInboxCount($parameters)->GetInboxCountResult;

        // there is error if we have negative result
        if ($res < 0) {
            $this->status = [
                'code' => $res,
                'message' => $this->sms_code_message['get_inbox_count'][$res] ?? $this->unknown_message,
            ];

            // call error closure
            if ($this->error_callback instanceof Closure) {
                call_user_func_array($this->error_callback, [$this->status['code'], $this->status['message'], $parameters]);
            }

            // if error happen
            return -1;
        }

        $this->is_successful = true;

        return $res;
    }

    /**
     *
     *
     * @param MessageProvider $message
     * @return static
     * @throws SMSException
     */
    public function sendBatchSms(MessageProvider $message)
    {
        // check some functionality
        $this->checker();

        if (!empty($message->getNumbers())) {
            throw new SMSException('Please specify numbers you want send message to');
        }
        if (empty($message->getBody())) {
            throw new SMSException('The body is empty! Please add some text to it');
        }

        $batchSmsId = $this->getParameter('batchSmsId');

        // define needed parameters
        $parameters = [
            'userName' => $this->getParameter('userName') ?: $this->username,
            'password' => $this->getParameter('password') ?: $this->password,
            'fromNumber' => $this->getParameter('fromNumber'),
            'messageContent' => $message->getBody(),
            'isFlash' => $this->getParameter('isFlash'),
            'batchSmsId' => &$batchSmsId,
        ];

        $allNumbers = $message->getNumbers();

        $successCount = 0;
        $mustSlice = ceil(count($allNumbers) / 100);

        for ($i = 0; $i < $mustSlice; $i++) {
            // Slice 100 numbers each time
            $parameters['toNumbers'] = array_slice($allNumbers, $i * 100, 100);

            // Send sms functionality
            $sendRes = $this->client->SendBatchSms($parameters)->SendBatchSmsResult;

            if ($sendRes == 0) {
                $successCount++;
            }

            if ($mustSlice == 1) {
                $this->status = [
                    'code' => $sendRes,
                    'message' => $this->sms_code_message['send_batch_sms'][$sendRes] ?? $this->unknown_message,
                ];
            } else {
                $this->status[] = [
                    'code' => $sendRes,
                    'message' => $this->sms_code_message['send_batch_sms'][$sendRes] ?? $this->unknown_message,
                ];
            }
        }

        $this->setParameter('batchSmsId', $batchSmsId);

        // check if all 100 pieces of numbers sent successfully
        if ($mustSlice == $successCount) {
            $this->is_successful = true;
        } else { // call error closure
            if ($this->error_callback instanceof Closure) {
                call_user_func_array($this->error_callback, [$this->status['code'], $this->status['message'], $parameters]);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     * @throws SMSException
     */
    public function getMessages()
    {
        // check some functionality
        $this->checker();

        // define needed parameters
        $parameters = [
            'userName' => $this->getParameter('userName') ?: $this->username,
            'password' => $this->getParameter('password') ?: $this->password,
            'messageType' => $this->getParameter('messageType'),
            'fromNumbers' => $this->getParameter('fromNumbers'),
            'index' => $this->getParameter('index'),
            'count' => $this->getParameter('count'),
        ];

        // call GetMessages function
        $res = $this->client->GetMessages($parameters)->GetMessagesResult;

        $this->setStatusToGeneralSuccess();

        return $res;
    }

    /**
     * Codes below are considered as success
     * [0, 1, 5] -> check GetDelivery method in docs
     *
     * @return mixed
     * @throws SMSException
     */
    public function getDelivery()
    {
        // check some functionality
        $this->checker();

        // define needed parameters
        $parameters = [
            'userName' => $this->getParameter('userName') ?: $this->username,
            'password' => $this->getParameter('password') ?: $this->password,
            'recId' => $this->getParameter('recId'),
        ];

        // call GetDelivery function
        $res = $this->client->GetDelivery($parameters)->GetDeliveryResult;

        $this->status = [
            'code' => $res,
            'message' => $this->sms_code_message['get_delivery'][$res] ?? $this->unknown_message,
        ];

        if (0 == $res || 1 == $res || 5 == $res) {
            $this->is_successful = true;
        } else { // call error closure
            if ($this->error_callback instanceof Closure) {
                call_user_func_array($this->error_callback, [$this->status['code'], $this->status['message'], $parameters]);
            }
        }

        return $res;
    }

    /**
     * @return mixed
     * @throws SMSException
     */
    public function numberIsInTelecomBlacklist()
    {
        // check some functionality
        $this->checker();

        // define needed parameters
        $parameters = [
            'userName' => $this->getParameter('userName') ?: $this->username,
            'password' => $this->getParameter('password') ?: $this->password,
            'number' => $this->getParameter('number'),
        ];

        // call NumberIsInTelecomBlacklist function
        $res = $this->client->NumberIsInTelecomBlacklist($parameters)->NumberIsInTelecomBlacklistResult;

        $this->status = [
            'code' => $res,
            'message' => $this->sms_code_message['number_is_in_telecom_blacklist'][$res] ?? $this->unknown_message,
        ];

        if (0 == $res) {
            $this->is_successful = true;
        } else { // call error closure
            if ($this->error_callback instanceof Closure) {
                call_user_func_array($this->error_callback, [$this->status['code'], $this->status['message'], $parameters]);
            }
        }

        return $res;
    }

    /**
     * @return mixed
     * @throws SMSException
     */
    public function extractTelecomBlacklistNumbers()
    {
        // check some functionality
        $this->checker();

        $blacklistNumbers = $this->getParameter('blacklistNumbers');

        // define needed parameters
        $parameters = [
            'userName' => $this->getParameter('userName') ?: $this->username,
            'password' => $this->getParameter('password') ?: $this->password,
            'numbers' => $this->getParameter('numbers'),
            'blacklistNumbers' => &$blacklistNumbers,
        ];

        // call ExtractTelecomBlacklistNumbers function
        $res = $this->client->ExtractTelecomBlacklistNumbers($parameters)->ExtractTelecomBlacklistNumbersResult;

        $this->status = [
            'code' => $res,
            'message' => $this->sms_code_message['extract_telecom_blacklist_numbers'][$res] ?? $this->unknown_message,
        ];

        $this->setParameter('blacklistNumbers', $blacklistNumbers);

        if (0 == $res) {
            $this->is_successful = true;
        } else { // call error closure
            if ($this->error_callback instanceof Closure) {
                call_user_func_array($this->error_callback, [$this->status['code'], $this->status['message'], $parameters]);
            }
        }

        return $res;
    }

    /**
     * @param array $message_providers
     * @return mixed
     * @throws SMSException
     */
    public function sendSmsLikeToLike(array $message_providers)
    {
        // check some functionality
        $this->checker();

        $smsId = $this->getParameter('smsId');

        //----- Extract numbers and messages
        $numbers = [];
        $messages = [];

        /**
         * @var MessageProvider $message_provider
         */
        foreach ($message_providers as $message_provider) {
            $number = $message_provider->getNumbers()[0] ?? '';
            if (!empty($number)) {
                $numbers[] = $number;
                $messages[] = $message_provider->getBody();
            }
        }
        //-----

        // if there is no number throw error
        if (!count($numbers)) {
            throw new SMSException('You need to add some numbers to send message to');
        }

        // define needed parameters
        $parameters = [
            'userName' => $this->getParameter('userName') ?: $this->username,
            'password' => $this->getParameter('password') ?: $this->password,
            'fromNumber' => $this->getParameter('fromNumber'),
            'toNumbers' => $numbers,
            'messageContents' => $messages,
            'isFlash' => $this->getParameter('isFlash'),
            'smsId' => &$smsId,
        ];

        // call SendSmsLikeToLike function
        $res = $this->client->SendSmsLikeToLike($parameters)->SendSmsLikeToLikeResult;

        $this->status = [
            'code' => $res,
            'message' => $this->sms_code_message['send_sms_like_to_like'][$res] ?? $this->unknown_message,
        ];

        $this->setParameter('smsId', $smsId);

        if (0 == $res) {
            $this->is_successful = true;
        } else { // call error closure
            if ($this->error_callback instanceof Closure) {
                call_user_func_array($this->error_callback, [$this->status['code'], $this->status['message'], $parameters]);
            }
        }

        return $res;
    }

    /**
     * If call <strong>send</strong> method and
     * count of numbers is greater than 100, it'll
     * return an associative array that contains
     * array of array of statuses. Otherwise return
     * status array like below
     * [
     *   'code' => operation code,
     *   'message' => operation message
     * ]
     *
     * {@inheritdoc}
     */
    public function getStatus(): array
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccessful(): bool
    {
        return $this->is_successful;
    }

    /**
     * Useful just after using send method
     *
     * @return array
     */
    public function getRecIds(): array
    {
        return $this->rec_ids;
    }

    /**
     * Check global functionality
     *
     * @throws SMSException
     */
    private function checker()
    {
        // reset is_successful
        $this->resetIsSuccessful();

        // reset re_ids
        $this->rec_ids = [];

        // set default status as success
        $this->setStatusToGeneralSuccess();

        if (empty($this->getParameter('userName')) && empty($this->username)) {
            throw new SMSException('Username needed to send request!');
        }
        if (empty($this->getParameter('password')) && empty($this->password)) {
            throw new SMSException('Password needed to send request!');
        }
    }
}