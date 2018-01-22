<?php

namespace Drupal\when_counter\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a 'When Counter' Block.
 *
 * @Block(
 *   id = "when_block",
 *   admin_label = @Translation("When block"),
 *   category = @Translation("When Counter"),
 * )
 */
class WhenBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $today = date("m/d/Y");
    $node_id = \Drupal::routeMatch()->getRawParameter('node');
    $node = Node::load($node_id);
    $eventdate = $node->get('field_event_date')->value;

    $todayTimestamp = strtotime($today);
    $eventdateTimestamp = strtotime($eventdate);
    
    $inbetween = $eventdateTimestamp - $todayTimestamp;
    $daysbetween = floor($inbetween / (60*60*24));
 
      if ($daysbetween > 0) {
        return array ('#markup' => ('Days left to event start:') . (' ') . $daysbetween);
        } elseif ($daysbetween < 0) {
            return array ('#markup' => ('The event has ended.'));
        } else {
            return array ('#markup' => ("This is today's event."));
        }
  }
    
  /**
  * {@inheritdoc}
  */
  public function getCacheMaxAge() {
  return 0;
  }
    
}