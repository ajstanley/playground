<?php

namespace Drupal\playground\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;
use Drupal\media\Entity\Media;
use Drupal\media\Entity\MediaType;
use Drupal\file\Entity\File;


/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {
    private $gridder;

    public function __construct($gridder) {
        $this->gridder = $gridder;
    }


    public static function create(ContainerInterface $container) {
        $gridder = $container->get('playground.gridder');
        return new static($gridder);
    }


    public function test() {

      $mid = '1';
      $media = Media::load($mid);
      $media_source_service = \Drupal::service('islandora.media_source_service');
      $field = \Drupal::entityTypeManager()->getStorage('field_storage_config')->load('media.field_service_file');
      $scheme = $field->getSetting('uri_scheme');
      $source_field = $media_source_service->getSourceFieldName($media->bundle());
      $expected_checksum = NULL;
      if ($media->hasField('field_expected_checksum')) {
        $expected_checksum = $media->get('field_expected_checksum')->value;
      }
      $fid = $media->$source_field->target_id;
      $file = File::load($fid);
      $checksum = $file->filehash['sha1'];
      if($expected_checksum) {
        if ($expected_checksum == $checksum) {
          \Drupal::messenger()->addMessage('File checksum verified.');
        }
        else {
          \Drupal::messenger()->addWarning('Uploaded file does not match expected checksum');
        }
      }


        $default = [
            '#theme' => 'playground',
            '#test_var' => $this->t("testing complete"),
        ];

        return $default;
    }

}
