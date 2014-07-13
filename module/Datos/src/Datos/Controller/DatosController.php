<?php

namespace Datos\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Datos\Model\Datos;
use Datos\Form\DatosForm;

class DatosController extends AbstractActionController
{
    protected $datosTabla;

    public function indexAction()
    {
        return new ViewModel(array(
            'datos' => $this->getDatosTabla()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new DatosForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $datos = new Datos();
            $form->setInputFilter($datos->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $datos->exchangeArray($form->getData());
                $this->getDatosTabla()->saveDatos($datos);


                return $this->redirect()->toRoute('datos');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('datos', array('action'=>'add'));
        }
        $datos = $this->getDatosTabla()->getDatos($id);

        $form = new DatosForm();
        $form->bind($datos);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getDatosTable()->saveDatos($datos);

                // Redirect to list of albums
                return $this->redirect()->toRoute('datos');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('datos');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $this->getDatosTabla()->deleteDatos($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('datos');
        }

        return array(
            'id' => $id,
            'datos' => $this->getDatosTabla()->getDatos($id)
        );
    }

    public function getDatosTabla()
    {
        if (!$this->datosTabla) {
            $sm = $this->getServiceLocator();
            $this->datosTabla = $sm->get('Datos\Model\DatosTabla');
        }
        return $this->datosTabla;
    }    
}
