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

    $group = $this->switcherService->getGroups([1]);

    
    $my_group_gtype = $this->switcherService->getGroupTypes([$group->bundle()]);


    $installed_plugins = $my_group_gtype->getInstalledContentPlugins();

    var_dump($installed_plugins);

    exit();


  }

  protected function getGroupsList() {
    // $this->switcherService
    // FINISH FORM PART LATER.
  }
}