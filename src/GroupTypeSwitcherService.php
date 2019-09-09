<?php

namespace Drupal\group_type_switcher;

use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Component\Datetime\TimeInterface;
use PDO;
use Drupal\Core\Database\Query\SelectInterface;
use Drupal\Core\Entity\EntityFieldManager;
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
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManager
   */
  protected $entityFieldManager;

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
  public function __construct(Connection $database, TimeInterface $date_time, LoggerChannelFactoryInterface $logger, EntityTypeManagerInterface $entity_type_manager, EntityFieldManager $entity_field_manager) {
    $this->database = $database;
    $this->dateTime = $date_time;
    $this->logger = $logger->get('group_type_switcher');
    $this->entityTypeManager = $entity_type_manager;
    $this->entityFieldManager = $entity_field_manager;
  }

  public function getGroups(array $ids = NULL) {
    $groups = $this->entityTypeManager->getStorage('group')->loadMultiple($ids);
    return (count($groups) > 1) ? $groups : reset($groups);
  }

  public function getGroupTypes(array $ids = NULL) {
    $group_types = $this->entityTypeManager->getStorage('group_type')->loadMultiple($ids);
    return (count($group_types) > 1) ? $group_types : reset($group_types);
  }

  public function getGroupContentTypes(array $ids = NULL) {
    $group_content_types = $this->entityTypeManager->getStorage('group_content_type')->loadMultiple($ids);
    return (count($group_content_types) > 1) ? array_keys($group_content_types)  :array_keys($group_content_types);
  }

  public function getEntityTables($entity_type = 'group'){
    $tables = [];

    foreach (['base_table','data_table'] as $t) {
      $tables[$t] = $this->entityTypeManager->getDefinition($entity_type)->get($t);
    }
    return $tables;
  }

  public function getFieldTables($entity_type_id = 'group', $bundle = 'fut_open'){

    $fields = $this->entityFieldManager->getFieldDefinitions($entity_type_id, $bundle);
    foreach ($fields as $field_name => $field_definition) {
      if (!empty($field_definition->getTargetBundle())) {
        $listFields[$field_name] = "{$entity_type_id}__{$field_name}";
        // $listFields[$field_name]['label'] = $field_definition->getLabel();
      }
    }
    // $rows = [];
    // foreach ($listFields as $field_name => $info) {
    //   $rows[$field_name] = $info;
    // }
    // return $rows;

    return $listFields;
  }



  public function updateBundleCols() {
    if (!$activity_record->isNew()) {
      $fields = [
        'activity' => $activity_record->getActivityValue(),
        'changed' => $this->dateTime->getRequestTime(),
      ];
      try {
        $this->database->update('fut_activity')
          ->fields($fields)
          ->condition('activity_id', $activity_record->id())
          ->execute();
      }
      catch (\Throwable $th) {
        $this->logger->error($th->getMessage());
        return FALSE;
      }
      return TRUE;
    }
  }





}
