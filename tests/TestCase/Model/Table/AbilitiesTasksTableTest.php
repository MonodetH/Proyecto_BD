<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AbilitiesTasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AbilitiesTasksTable Test Case
 */
class AbilitiesTasksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AbilitiesTasksTable
     */
    public $AbilitiesTasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.abilities_tasks',
        'app.abilities',
        'app.tasks',
        'app.missions',
        'app.emergencies',
        'app.users',
        'app.communes',
        'app.regions',
        'app.problems',
        'app.requests',
        'app.docs',
        'app.docs_tasks',
        'app.tasks_users',
        'app.abilities_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AbilitiesTasks') ? [] : ['className' => 'App\Model\Table\AbilitiesTasksTable'];
        $this->AbilitiesTasks = TableRegistry::get('AbilitiesTasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AbilitiesTasks);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
