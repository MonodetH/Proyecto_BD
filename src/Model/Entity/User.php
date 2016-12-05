<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property int $commune_id
 * @property string $nombre_usuario
 * @property string $password
 * @property bool $disponibilidad
 * @property bool $admin
 *
 * @property \App\Model\Entity\Commune $commune
 * @property \App\Model\Entity\Email[] $emails
 * @property \App\Model\Entity\Emergency[] $emergencies
 * @property \App\Model\Entity\Message[] $messages
 * @property \App\Model\Entity\Mission[] $missions
 * @property \App\Model\Entity\Phone[] $phones
 * @property \App\Model\Entity\Request[] $requests
 * @property \App\Model\Entity\Ability[] $abilities
 * @property \App\Model\Entity\Notification[] $notifications
 * @property \App\Model\Entity\Task[] $tasks
 */
class User extends Entity
{

    /**
     * Funcion que obtiene la lista de misiones asociadas a un usuario
     *
     * @return Lista de Entity Mission asociadas a Usuario, NULL si no existen.
     */
    public function getMissions(){
        $missionsTable = TableRegistry::get('Missions');
        
        $result = $missionsTable->find()->where(['user_id'=>$this->id]);

        return $result;
    }

    /**
     * Funcion que obtiene la lista de misiones asociadas a un usuario
     *
     * @return Lista de Entity Mission asociadas a Usuario, NULL si no existen.
     */
    public function hasMissions(){
        $missionsTable = TableRegistry::get('Missions');
        
        $result = $missionsTable->find()->where(['user_id'=>$this->id])->first();

        return ($result)? 1 : 0;
    }



    /********************************/
    /*** METODOS CREADOS POR BAKE ***/
    /********************************/

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
