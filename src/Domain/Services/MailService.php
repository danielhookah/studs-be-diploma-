<?php

namespace App\Domain\Services;

use App\Infrastructure\Shared\Exception\SendEmailException;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Log\LoggerInterface;

/**
 * Class MailService
 * @package App\Domain\Services
 */
class MailService extends Service
{
    private PHPMailer $mail;

    private array $templates = [
        'invite' => MAINDOMAIN . '/assets/mailings/invite.html',
        'reset-password' => MAINDOMAIN . '/assets/mailings/reset-password.html'
    ];

    /**
     * MailService constructor.
     * @param LoggerInterface $logger
     * @throws SendEmailException
     */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);

        // host
        $emailFrom = getenv('MAIL_LOGIN');
        $pass = getenv('MAIL_PASSWORD');
        $host = getenv('MAIL_HOST');

        $this->mail = new PHPMailer(true);
        $this->mail->CharSet = "utf-8";

        // server settings
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host = $host;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $emailFrom;
        $this->mail->Password = $pass;
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port = 465;

        try {
            $this->mail->setFrom($emailFrom, 'Studs');
        } catch (Exception $e) {
            $this->logger->info("! Error while setting email from. Message: " . $e->getMessage());
            throw new SendEmailException('Could not set configuration');
        }

        $this->mail->isHTML(true);
        $this->mail->Subject = 'Studs. E-learning platform';
        $this->mail->AltBody = 'Studs';
    }

    /**
     * @param array $params
     * @param string $templateName
     * @throws SendEmailException
     */
    public function send(array $params, string $templateName)
    {
        try {
            $emailTo = $params['email'];
            $firstName = $params['firstName'];
            $lastName = $params['lastName'] || '';

            $templateContent = file_get_contents($this->templates[$templateName]);
            if (!$templateContent) {
                $this->logger->info("! Error while creating template content. Message: could not get template content");
                throw new SendEmailException('Could not get template content');
            }

            $template = $this->prepareTemplate($params['dataToReplace'], $templateContent);

            $this->mail->addAddress($emailTo, "$firstName $lastName");
            $this->mail->Body = $template;
            $this->mail->send();
        } catch (Exception $e) {
            $this->logger->info("! Error while sending email. Message: " . $e->getMessage());
            throw new SendEmailException('Could not send email');
        }
    }

    /**
     * @param array|null $paramsToReplace
     * @param string $template
     * @return string
     */
    private function prepareTemplate(?array $paramsToReplace, string $template)
    {
        foreach ($paramsToReplace as $param => $value) {
            str_replace("[[$param]]", $value, $template);
        }

        return $template;
    }

}
