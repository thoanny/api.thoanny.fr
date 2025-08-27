<?php

namespace App\Controller\Admin;

use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/file')]
#[IsGranted('ROLE_ADMIN')]
final class FileController extends AbstractController
{
    /**
     * @throws RandomException
     */
    #[Route('/upload', name: 'app_admin_file_upload', methods: 'POST')]
    public function upload(Request $request): JsonResponse
    {
        $file = $request->files->get('image') ?? $request->files->get('file');
        if (!$file) {
            return new JsonResponse(['success' => 0], 400);
        }

        $root = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/uploads/';
        $extension = $file->guessExtension();
        $size = $file->getSize();
        $originalName = $file->getClientOriginalName();
        $filename = $this->generateName($extension);

        try {
            $file->move($this->getParameter('uploads_directory'), $filename);
        } catch (FileException) {
            return new JsonResponse(['success' => 0]);
        }

        return new JsonResponse([
            'success' => 1,
            'file' => [
                'url' => $root.$filename,
                'size' => $size,
                'name' => $originalName,
                'extension' => $extension
            ],
        ]);
    }

    /**
     * @throws RandomException
     */
    #[Route('/fetch', name: 'app_admin_file_fetch', methods: 'POST')]
    public function fetch(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent());
        $url = $content->url ?? null;
        if(!$url) {
            return new JsonResponse(['success' => 0], 400);
        }

        $file = @file_get_contents($url);
        if(!$file) {
            return new JsonResponse(['success' => 0], 404);
        }

        $extension = pathinfo($url, PATHINFO_EXTENSION);
        $name = pathinfo($url, PATHINFO_FILENAME);
        $root = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/uploads/';
        $filename = $this->generateName($extension);
        file_put_contents($this->getParameter('uploads_directory').'/'.$filename, $file);

        return new JsonResponse([
            'success' => 1,
            'file' => [
                'url' => $root.$filename,
                'size' => strlen($file),
                'name' => "$name.$extension",
                'extension' => $extension,
                'source' => $url
            ]
        ]);
    }

    /**
     * @throws RandomException
     */
    private function generateName($extension): string
    {
        $name = '';
        for ($i = 0; $i < 10; ++$i) {
            $name .= $this->getRandomChar();
        }

        if ($extension) {
            $name = "$name.$extension";
        }

        return $name;
    }

    protected const ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';

    /**
     * @throws RandomException
     */
    protected function getRandomChar(): string
    {
        return self::ALPHABET[\random_int(0, 63)];
    }
}
