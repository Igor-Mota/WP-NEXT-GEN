<?php
class WebpConverter
{
  // META_KEY_FLAG é mantida para o cache "DB First" (verificação rápida no banco).
  public const META_KEY_FLAG = '_webp_cache_exists';

  /**
   * Executa a conversão de JPEG/PNG para WebP usando a extensão GD.
   * O WebP é salvo no mesmo diretório do arquivo original.
   * * @param string $source_path Caminho absoluto da imagem original (JPG/PNG).
   * @return bool True se a conversão for bem-sucedida, false caso contrário.
   */
  public static function createWebp(string $source_path): bool
  {
    // 1. O NOVO CAMINHO DE DESTINO: Substitui a extensão original (.jpg/.png) por .webp
    $destination_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $source_path);

    if (!extension_loaded('gd') || !function_exists('imagewebp')) {
      error_log('GD ou imagewebp não estão disponíveis para conversão WebP.');
      return false;
    }

    // O bloco de criação de diretório ('$cache_dir') é removido, 
    // pois o diretório de destino já existe (é a pasta de upload do WordPress).

    $mime_type = mime_content_type($source_path);
    $image = null;

    switch ($mime_type) {
      case 'image/jpeg':
        $image = imagecreatefromjpeg($source_path);
        break;
      case 'image/png':
        $image = imagecreatefrompng($source_path);

        if ($image) {
          imagepalettetotruecolor($image);
          imagealphablending($image, false);
          imagesavealpha($image, true);
        }
        break;
      default:
        // Se não for JPG ou PNG, não converte.
        return false;
    }

    if ($image === null) {
      return false;
    }

    $success = imagewebp($image, $destination_path, 90);

    imagedestroy($image);

    return $success;
  }

  /**
   * * @param string $original_url URL completa do JPG/PNG original.
   * @param array $upload_dir Array retornado por wp_upload_dir().
   * @return string A URL completa do WebP.
   */
  public static function getWebpUrlFromOriginal(string $original_url, array $upload_dir): string
  {
    // Simplesmente substitui a extensão na URL.
    $webp_url = preg_replace('/\.(jpe?g|png)$/i', '.webp', $original_url);

    // Se a substituição falhar ou o arquivo não for JPG/PNG, retorna a original (segurança).
    if ($webp_url === $original_url) {
      return $original_url;
    }

    return $webp_url;
  }
}