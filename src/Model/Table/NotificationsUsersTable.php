<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotificationsUsers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Notifications
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\NotificationsUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotificationsUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotificationsUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotificationsUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotificationsUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotificationsUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotificationsUser findOrCreate($search, callable $callback = null)
 */
class NotificationsUsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('notifications_users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Notifications', [
            'foreignKey' => 'notification_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['notification_id'], 'Notifications'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
