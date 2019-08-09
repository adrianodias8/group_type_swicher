<?php

namespace Drupal\group_type_switcher;

use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Component\Datetime\TimeInterface;
use PDO;
use Drupal\Core\Database\Query\SelectInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class GroupTypeSwitcherService.
 */
class GroupTypeSwitcherService {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * The date time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $dateTime;

  /**
   * A logger instance.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $logger;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new GroupTypeSwitcherService object.
   *
   * @param \Drupal\Core\Database\Driver\mysql\Connection $database
   *   The active database connection.
   * @param \Drupal\Component\Datetime\TimeInterface $date_time
   *   The time service.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   The logger channel factory.
   */
  public function __construct(Connection $database, TimeInterface $date_time, LoggerChannelFactoryInterface $logger, EntityTypeManagerInterface $entity_type_manager) {
    $this->database = $database;
    $this->dateTime = $date_time;
    $this->logger = $logger->get('group_type_switcher');
    $this->entityTypeManager = $entity_type_manager;
  }

  public function getGroups(array $ids = NULL) {
    $groups = $this->entityTypeManager->getStorage('group')->loadMultiple($ids);
    return (count($groups) > 1) ? $groups : reset($groups);
  }

  public function getGroupTypes(array $ids = NULL) {
    $group_types = $this->entityTypeManager->getStorage('group_type')->loadMultiple($ids);
    return (count($group_types) > 1) ? $group_types : reset($group_types);
  }



  

}
