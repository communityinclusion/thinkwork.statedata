<?php

namespace Drupal\content_access\Plugin\RulesAction;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\rules\Core\RulesActionBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Revoke access by role' action.
 *
 * @RulesAction(
 *   id = "content_access_action_revoke_node_permissions",
 *   label = @Translation("Revoke access by role"),
 *   category = @Translation("Content Access"),
 *   context_definitions = {
 *     "node" = @ContextDefinition("entity:node",
 *       label = @Translation("Content"),
 *       description = @Translation("Revoke access from the following content.")
 *     ),
 *     "permissions" = @ContextDefinition("string",
 *       label = @Translation("Role-based access control settings."),
 *       required = FALSE
 *     )
 *   }
 * )
 *
 * @todo Add option_list parameter to permissions after it becomes available.
 */
class ActionRevokeNodePermissions extends RulesActionBase implements ContainerFactoryPluginInterface {
  use ActionCommonTrait;

  /**
   * Defined $logger.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LoggerChannelFactoryInterface $logger) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('logger.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function execute() {
    $node = $this->getContextValue('node');
    $permissions = $this->getContextValue('permissions');

    if (!empty($node->id()) && $this->checkSetting($node)) {
      // Transform the value to the content-access format.
      $settings = $this->transformRulesValue($permissions);

      $ca_settings = [];
      foreach (_content_access_get_operations() as $op => $label) {
        $settings += [$op => []];
        $ca_settings[$op] = array_diff(content_access_per_node_setting($op, $node), $settings[$op]);
      }
      content_access_save_per_node_settings($node, $ca_settings);
      $this->aquireGrants($node);
    }
  }

}
