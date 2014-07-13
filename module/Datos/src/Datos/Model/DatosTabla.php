<?php

namespace Datos\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class DatosTabla extends AbstractTableGateway
{
    protected $table = 'personales';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Datos());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getDatos($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveDatos(Datos $datos)
    {
        $data = array(
            'nombre' => $datos->nombre,
            'foto'  => $datos->foto,
            'edad'  => $datos->edad,
        );

        $id = (int)$datos->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getDatos($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteDatos($id)
    {
        $this->delete(array('id' => $id));
    }

}
