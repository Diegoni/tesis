<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">
                
            </li>
            <ul class="sidebar-menu">
                <li class="header">
                </li>
                <?php
                $url = $this->uri->segment(1).'/'.$this->uri->segment(2).'/';
                $active = 0;
                
                if($session['permisos'])
                {
                    foreach ($session['permisos'] as $row) 
                    {
                        if($row['ver'] == 1){
                            if($row['id_padre'] != 0){
                                if($row['url'] == $url){
                                    $class = 'class="active"';
                                    $active = $row['id_padre'];
                                }else{
                                    $class = '';
                                }
                                
                                
                                if($row['icon'] == ''){
                                    $icon = 'fa fa-circle-o'; 
                                }else {
                                    $icon = $row['icon'];
                                }
                                
                                $submenu = '<li>';
                                $submenu .= '<a href="'.base_url().'index.php/'.$row['url'].'" '.$class.' >';
                                $submenu .= '<i class="'.$icon.'"></i> '.$row['menu'].'</a>';
                                $submenu .= '</li>';
                                
                                $array_menus[$row['id_padre']][] = array(
                                    'submenu'   => $submenu,
                                );    
                            }else{
                                $categorias[] = array(
                                    'id_permiso'  => $row['id_permiso'],
                                    'menu'      => $row['menu'], 
                                    'icon'      => $row['icon'],
                                );
                            }
                        }                            
                    }
                    
                    foreach ($categorias as $row_categoria) {
                        if($active == $row_categoria['id_permiso']){
                            $class = 'active';
                        }else{
                            $class = '';
                        }
                        
                        
                        $comienzo  = '<li class="treeview '.$class.'">'; 
                        
                        if($row_categoria['icon'] == ''){
                            $icon = 'fa fa-circle-o'; 
                        }else {
                            $icon = $row_categoria['icon'];
                        }
                        
                        
                        
                        $comienzo .= '<a href="#">
                                            <i class="'.$icon.'"></i>
                                            <span>'.$row_categoria['menu'].'</span>
                                            <i class="fa fa-angle-left pull-right"></i>
                                          </a>';
                       $comienzo .= '<ul class="treeview-menu menu-open">'; 
                           
                       $final = '</ul></li>';
                       $_submenu   = '';
                        
                       if(isset($array_menus) && isset($array_menus[$row_categoria['id_permiso']])){
                            foreach ($array_menus[$row_categoria['id_permiso']] as $grupo => $_menus) {
                                $bandera    = 0;
                                $_submenu .= $_menus['submenu'];
                            }
                        }

                        echo $comienzo.$_submenu.$final;
                    }
                }
                
                ?>
            </ul>
        </ul>            
    </section>
</aside>
<div class="content-wrapper">
    <section class="content-header fadeInLeft wow" data-wow-duration="1500">
        <h1>
        <?php 
        $titulo     = str_replace("_", " ", $subjet);
        $subtitulo  = str_replace("_", " ", $this->uri->segment(2));
        echo $titulo; 
        echo '<small>'.$subtitulo.'</small>';
        ?>
        </h1>
    </section>