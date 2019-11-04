<?php
class PicUpload
{
    private $tempName;
    private $imageFileType;
    private $myTempImage;
    private $myNewImage;

    function __construct($tempName, $imageFileType)
    {
        $this->tempName = $tempName;
        $this->imageFileType = $imageFileType;
        $this->createImageFromFile();
    }

    function __destruct()
    {
        imagedestroy($this->myTempImage);
        imagedestroy($this->myNewImage);
    }

    private function createImageFromFile()
    {
        if ($this->imageFileType == "jpg" || $this->imageFileType == "jpeg") {
            $this->myTempImage = imagecreatefromjpeg($this->tempName);
        } elseif ($this->imageFileType == "png") {
            $this->myTempImage = imagecreatefrompng($this->tempName);
        } elseif ($this->imageFileType == "gif") {
            $this->myTempImage = imagecreatefromgif($this->tempName);
        }
    }

    public function resizeImage($picMaxW, $picMaxH)
    {
        $imageW = imagesx($this->myTempImage);
        $imageH = imagesy($this->myTempImage);

        if ($imageW > $picMaxW || $imageH > $picMaxH) {
            if ($imageW / $picMaxW > $imageH / $picMaxH) {
                $picSizeRatio = $imageW / $picMaxW;
            } else {
                $picSizeRatio = $imageH / $picMaxH;
            }
            // Loome uue pildiobjekti uute mõõtudega
            $newW = round($imageW / $picSizeRatio, 0);
            $newH = round($imageH / $picSizeRatio, 0);
            $this->myNewImage = $this->setPicSize($this->myTempImage, $imageW, $imageH, $newW, $newH);
        }
    }

    private function setPicSize($myTempImage, $imageW, $imageH, $newW, $newH)
    {
        $newImage = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($newImage, $myTempImage, 0, 0, 0, 0, $newW, $newH, $imageW, $imageH);
        return $newImage;
    }

    public function addWatermark($waterMarkFile) {
        $waterMark = imagecreatefrompng($waterMarkFile);
        $watermarkW = imagesx($waterMark);
        $watermarkH = imagesy($waterMark);

        $watermarkX = imagesx($this->myNewImage) - $watermarkW - 10;
        $watermarkY = imagesy($this->myNewImage) - $watermarkH - 10;

        imagecopy($this->myNewImage, $waterMark, $watermarkX, $watermarkY, 0, 0, $watermarkW, $watermarkH);
        
        imagedestroy($waterMark);
    }

    public function saveImage($targetFile)
    {
        // Salvestan vähendatud pildifaili
        if ($this->imageFileType == "jpg" || $this->imageFileType == "jpeg") {
            if (imagejpeg($this->myNewImage, $targetFile, 83)) {
                $notice = "Vähendatud pildisalvestamine õnnestus! ";
            } else {
                $notice = "Läks purki :( ";
            }
        } elseif ($this->imageFileType == "png") {
            if (imagepng($this->myNewImage, $targetFile, 0)) {
                $notice = "Vähendatud pildisalvestamine õnnestus! ";
            } else {
                $notice = "Läks purki :( ";
            }
        } elseif ($this->imageFileType == "gif") {
            if (imagegif($this->myNewImage, $targetFile)) {
                $notice = "Vähendatud pildisalvestamine õnnestus! ";
            } else {
                $notice = "Läks purki :( ";
            }
        }
        return $notice;
    }
}
