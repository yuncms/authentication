<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\authentication;

use Yii;
use yii\base\InvalidConfigException;
use yuncms\helpers\FileHelper;
use League\Flysystem\AdapterInterface;

/**
 * Class Module
 * @package yuncms\authentication
 */
class Module extends \yuncms\base\Module
{
    /**
     * 初始化存储
     * @throws InvalidConfigException
     */
//    public function init()
//    {
//        parent::init();
//        if (!Yii::$app->getFilesystem()->has(Yii::$app->settings->get('volume', 'authentication', 'authentication'))) {
//            throw new InvalidConfigException("Unknown storage configuration.");
//        }
//    }

    /**
     * 获取头像存储卷
     * @return object|\yuncms\filesystem\Adapter
     * @throws \yii\base\InvalidConfigException
     */
    public static function getVolume()
    {
        return Yii::$app->getFilesystem()->get(Yii::$app->settings->get('volume', 'authentication', 'authentication'));
    }

    /**
     * 计算用户头像子路径
     *
     * @param int $userId 用户ID
     * @param string $fileName 图片名称
     * @return string
     */
    public static function getSubPath($userId, $fileName)
    {
        $id = sprintf("%09d", $userId);
        $dir1 = substr($id, 0, 3);
        $dir2 = substr($id, 3, 2);
        $dir3 = substr($id, 5, 2);
        return $dir1 . '/' . $dir2 . '/' . $dir3 . '/' . substr($userId, -2) . $fileName;
    }

    /**
     * 删除图片
     * @param int $userId 用户ID
     * @param string $image
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function deleteImage($userId, $image): bool
    {
        $idCardPath = self::getSubPath($userId, $image);
        if (self::getVolume()->has($idCardPath)) {
            return self::getVolume()->delete($idCardPath);
        }
        return true;
    }

    /**
     * 保存图片
     * @param int $userId 用户ID
     * @param string $originalImage
     * @param string $targetImage
     * @return string 存储路径
     * @throws \yii\base\ErrorException
     * @throws \yii\base\InvalidConfigException
     */
    public static function saveImage($userId, $originalImage, $targetImage)
    {
        $idCardPath = self::getSubPath($userId, $targetImage);
        if (self::getVolume()->has($idCardPath)) {
            self::getVolume()->delete($idCardPath);
        }
        self::getVolume()->write($idCardPath, FileHelper::readAndDelete($originalImage), [
            'visibility' => AdapterInterface::VISIBILITY_PRIVATE
        ]);
        return $idCardPath;
    }
}
