<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Datos\Controller\Album' => 'Datos\Controller\DatosController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'datos' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/datos[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Datos\Controller\Datos',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'album' => __DIR__ . '/../view',
         ),
     ),
 );