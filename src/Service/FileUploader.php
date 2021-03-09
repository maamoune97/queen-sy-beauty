<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectoryPath;
    private $targetDirectoryName;
    private $slugger;

    public function __construct($targetDirectoryPath, $targetDirectoryName, SluggerInterface $slugger)
    {
        $this->targetDirectoryPath = $targetDirectoryPath;
        $this->targetDirectoryName = $targetDirectoryName;
        $this->slugger = $slugger;
    }

    /**
     * Undocumented function
     *
     * @param UploadedFile $file fichier à upluoder
     * @param string $pathDirectory chemin du dossier sans les slash du debut et fin
     * @return string $url
     */
    public function upload(UploadedFile $file, string $pathDirectory)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try
        {
            $file->move($this->getTargetDirectoryPath().$pathDirectory.'/', $fileName);
        } catch (FileException $e)
        {
            throw $e;
            // ... handle exception if something happens during file upload
        }

        $url = $this->getTargetDirectoryName().$pathDirectory.'/'.$fileName;
        return $url;
        //return $fileName;
    }

    public function getTargetDirectoryPath()
    {
        return $this->targetDirectoryPath;
    }

    public function getTargetDirectoryName()
    {
        return $this->targetDirectoryName;
    }
}
