<?php

/**
 * @file
 * Provides the Documentation block.
 */

namespace Drupal\xio_documentation\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides the Documentation block.
 *
 * @Block(
 *   id = "documentation_block",
 *   admin_label = @Translation("XIO Documentation"),
 * )
 */
class XioDocumentationBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $intros = \Drupal::config('xio_documentation.settings')->get('intros');

    $button = '<div id="documentation-toggle">' .
      t('Hide digital training information') .
      '|' .
      t('Show digital training information') .
      '</div>';

    $output = '';
    $current_path = \Drupal::service('path.current')->getPath();
    if (!empty($intros) && array_key_exists($current_path, $intros)) {
      $output = '<div class="description full-text">' . $intros[$current_path]['intro'] . '</div>';
    }

    return array(
      '#markup' => $button . $output,
      '#attached' => array(
        'library' => 'xio_documentation/xio-documentation',
      ),
      '#cache' => array(
        'contexts' => array(
          'url.path',
        ),
      ),
    );
  }
}
