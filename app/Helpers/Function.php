<?php



use App\Enums\ImagePhotoType;
use App\Models\Organization;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Illuminate\Support\Facades\Log;




function uploadFile($file, array $requiredFileType, string $path, ?string $maxFileSize)
{
    if (!$file) {
        throw new Error("No file selected");
    }

    $filename   = $file->getClientOriginalName();
    $extension  = strtolower($file->getClientOriginalExtension()); // Convert to lowercase
    $size       = $file->getSize();
    $slugFilename = Str::of($filename)->slug();
    $newFileName = $slugFilename . '.' . $extension;

    $requiredFileType = array_map('strtolower', $requiredFileType); // Ensure all expected types are lowercase

    if (!in_array($extension, $requiredFileType)) {
        $requiredFileTypeString = implode(", ", $requiredFileType);
        throw new Error("Unsupported File Format. Expecting: " . $requiredFileTypeString);
    }

    if ($maxFileSize && $size > $maxFileSize) {
        throw new Error("The maximum filesize required is " . bytesToMB($maxFileSize));
    }

    try {
        $pathToImage = $file->move(public_path($path), $newFileName);

        // Compress image if it's an image file
        $fullPath = public_path($path) . '/' . $newFileName;
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            compressImage($fullPath, $extension);
        }
    } catch (\Throwable $err) {
        throw new Error('An error occurred - ' . $err->getMessage());
    }

    return $newFileName;
}

/**
 * Compress and resize image to reasonable dimensions
 * Max width: 1200px, quality: 75%
 */
function compressImage(string $filePath, string $extension, int $maxWidth = 1200, int $quality = 75)
{
    if (!file_exists($filePath)) {
        return;
    }

    list($width, $height) = getimagesize($filePath);

    // Only resize if larger than max width
    if ($width > $maxWidth) {
        $ratio = $maxWidth / $width;
        $newWidth = $maxWidth;
        $newHeight = (int) round($height * $ratio);
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    // Create image resource based on type
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $source = imagecreatefromjpeg($filePath);
            break;
        case 'png':
            $source = imagecreatefrompng($filePath);
            break;
        case 'webp':
            $source = imagecreatefromwebp($filePath);
            break;
        default:
            return;
    }

    if (!$source) {
        return;
    }

    // Create resized image
    $destination = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG
    if ($extension === 'png') {
        imagealphablending($destination, false);
        imagesavealpha($destination, true);
    }

    imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save compressed image
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($destination, $filePath, $quality);
            break;
        case 'png':
            // PNG quality is 0-9 (0 = no compression, 9 = max)
            $pngQuality = (int) round((100 - $quality) / 11.1);
            imagepng($destination, $filePath, $pngQuality);
            break;
        case 'webp':
            imagewebp($destination, $filePath, $quality);
            break;
    }

    imagedestroy($source);
    imagedestroy($destination);
}


function bytesToMB($bytes)
{
    return $bytes / (1024 * 1024) . 'MB';
}

function deleteExistFile(string $path, string $fileName)
{
    if (file_exists(public_path($path) . $fileName)) {
        unlink(public_path($path) . $fileName);
    }
    return true;
}

function showFileUrl(string $path, string|null $fileName)
{
    if ($fileName && file_exists(public_path($path) . $fileName)) {
        return url($path . $fileName);
    }
    if (!$fileName && $path == ImagePhotoType::USER_DP->value) {
        return url(ImagePhotoType::USER_DP->value . "defaultDp.png");
    }

    if(!$fileName && $path == ImagePhotoType::LOGO->value)
    {
          return url(ImagePhotoType::LOGO->value . "paycitaLogo.png");
    }
    return null;
}









