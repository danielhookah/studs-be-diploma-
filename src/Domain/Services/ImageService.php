<?php

namespace App\Domain\Services;

use App\Infrastructure\Shared\Exception\SendEmailException;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Log\LoggerInterface;

/**
 * Class ImageService
 * @package App\Domain\Services
 */
class ImageService extends Service
{
    public $imagePath = IMAGE_PATH;
    public $folderURL = FOLDER_URL;

    /**
     * ImageService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    public function setMainName(string $name)
    {
        $this->imagePath .= $name;
        $this->folderURL .= $name;

        if (!file_exists($this->imagePath)) {
            if (!mkdir($this->imagePath, 0777, true)) {
                throw new \Exception('Can`t create folder for project image');
            }
        }
    }

    /**
     * @param $data
     * @param $entityId
     * @return string
     * @throws Exception
     */
    public function base64ToImage($data, $entityId) {
        $filename = $this->generateUniqImageName($this->imagePath, $entityId);

        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new Exception('invalid image type');
            }

            if (!$data = base64_decode($data)) {
                throw new Exception('base64_decode failed');
            }
        } else {
            // if $data is URL with image
            return $data;
        }

        if (!file_put_contents("$this->imagePath{$filename}.{$type}", $data)) {
            throw new Exception('Failed to put file contents');
        }

        return "$this->folderURL{$filename}.{$type}";
    }

    /**
     * @param $currentPath
     * @param string $entityName
     * @return string
     */
    public function generateUniqImageName($currentPath, $entityName = '')
    {
        $randomImageName = generateRandomString(5) . '-' . $entityName;
        if (file_exists($currentPath . $randomImageName)) {
            return self::generateUniqImageName($currentPath, $entityName);
        }

        return $randomImageName;
    }
}
