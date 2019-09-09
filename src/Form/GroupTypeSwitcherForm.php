<?php

namespace Drupal\group_type_switcher\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\group_type_switcher\GroupTypeSwitcherService;

/**
 * Implements an example form.
 */
class GroupTypeSwitcherForm extends FormBase {

  /**
   * @var GroupTypeSwitcherService $switcherService
   */
  protected $switcherService;

  /**example
   * Class constructor.
   */
  public function __construct(GroupTypeSwitcherService $switcher_service) {
    $this->switcherService = $switcher_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('group_type_switcher.switcher_service')
    );
  }

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'group_type_switcher_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // test case swich group (gid 1) from fut_open to fut_private
    $gid = 1;

    // Selected group type in this case "private".
    $selected_group_type = 'fut_private';

    $group = $this->switcherService->getGroups([1]);
    $my_group_gtype = $this->switcherService->getGroupTypes([$group->bundle()]);

    $selected_group_gtype = $this->switcherService->getGroupTypes([$selected_group_type]);


    $myg_installed_plugins = $my_group_gtype->getInstalledContentPlugins();

    $selected_installed_plugins = $selected_group_gtype->getInstalledContentPlugins();

    // kint($selected_installed_plugins->getConfiguration());
    echo "<h2>plugins</h2>";
    var_dump(array_keys($myg_installed_plugins->getConfiguration()));
    echo "<h2>group content types</h2>";
    var_dump($this->switcherService->getGroupContentTypes());
    // var_dump($this->switcherService->getGroupContentTypes(['fut_open-group_node-fut_post']));



    // var_dump($selected_installed_plugins->getConfiguration() == $myg_installed_plugins->getConfiguration());
    echo "<h2>group tables</h2>";
    var_dump($this->switcherService->getEntityTables());
    echo "<h2>group content tables</h2>";

    var_dump($this->switcherService->getEntityTables('group_content'));
    echo "<h2>group - fut_open- field tables</h2>";
    var_dump($this->switcherService->getFieldTables('group','fut_open'));
    echo "<h2>group_content - fut_open-group_node-fut_post - field tables</h2>";
    var_dump($this->switcherService->getFieldTables('group_content','fut_open-group_node-fut_post'));


    exit();


  }

  protected function getGroupsList() {
    // $this->switcherService
    // FINISH FORM PART LATER.
  }
}