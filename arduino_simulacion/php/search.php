<?php

function getSearch($tambos)
{
	$html = '<aside class="spaces-list" id="spaces-list">
				<div class="search">
					<input class="search__input" placeholder="Buscar..." />
					<button class="boxbutton boxbutton--darker close-search" aria-label="Close details"><svg class="icon icon--cross"><use xlink:href="#icon-cross"></use></svg></button>
				</div>
				<span class="label">
					<input id="sort-by-name" class="label__checkbox" type="checkbox" aria-label="Show alphabetically"/>
					<label class="label__text">A - Z</label>
				</span>
				<ul class="list grouped-by-category">';
                
                foreach ($tambos as $key => $row) 
                {
                    $aux[$key] = $row['id_tipo'];
                }
                array_multisort($aux, SORT_ASC, $tambos);
                foreach ($tambos as $tambo) 
                {
                    $html .= '<li class="list__item" data-level="1" data-category="'.$tambo['id_tipo'].'" data-space="1.0'.$tambo['id_sector'].'"><a href="#" class="list__link">'.$tambo['sector'].'</a></li>';
                }
				
					/*
					<li class="list__item" data-level="1" data-category="1" data-space="1.01"><a href="#" class="list__link">Oficinas</a></li>
					<li class="list__item" data-level="1" data-category="1" data-space="1.02"><a href="#" class="list__link">Veterinaria</a></li>
					<li class="list__item" data-level="1" data-category="1" data-space="1.06"><a href="#" class="list__link">Maternidad</a></li>
					<li class="list__item" data-level="1" data-category="1" data-space="1.07"><a href="#" class="list__link">Sala de ordene 2</a></li>
					<li class="list__item" data-level="1" data-category="2" data-space="1.03"><a href="#" class="list__link">Corral 2</a></li>
					
					<li class="list__item" data-level="2" data-category="2" data-space="2.02"><a href="#" class="list__link">Rocketship Tech</a></li>
					<li class="list__item" data-level="2" data-category="2" data-space="2.03"><a href="#" class="list__link">Which Bug?</a></li>
					<li class="list__item" data-level="3" data-category="2" data-space="3.02"><a href="#" class="list__link">Enlightend Path</a></li>
					<li class="list__item" data-level="4" data-category="2" data-space="4.02"><a href="#" class="list__link">Docu Dome</a></li>
					<li class="list__item" data-level="4" data-category="3" data-space="4.03"><a href="#" class="list__link">Little Artist</a></li>
					<li class="list__item" data-level="3" data-category="3" data-space="3.04"><a href="#" class="list__link">Your Last Shirt</a></li>
					<li class="list__item" data-level="2" data-category="3" data-space="2.08"><a href="#" class="list__link">Tool Exchange</a></li>
					<li class="list__item" data-level="1" data-category="3" data-space="1.04"><a href="#" class="list__link">Dress me not</a></li>
					<li class="list__item" data-level="2" data-category="3" data-space="2.04"><a href="#" class="list__link">Cognitio</a></li>
					<li class="list__item" data-level="3" data-category="3" data-space="3.03"><a href="#" class="list__link">What makes us walk</a></li>
					<li class="list__item" data-level="2" data-category="3" data-space="2.07"><a href="#" class="list__link">No Princess</a></li>
					<li class="list__item" data-level="3" data-category="4" data-space="3.07"><a href="#" class="list__link">Star Gazer</a></li>
					<li class="list__item" data-level="4" data-category="4" data-space="4.04"><a href="#" class="list__link">Space 16</a></li>
					<li class="list__item" data-level="3" data-category="4" data-space="3.05"><a href="#" class="list__link">Breathe</a></li>
					<li class="list__item" data-level="1" data-category="4" data-space="1.05"><a href="#" class="list__link">Meditation Garden</a></li>
					<li class="list__item" data-level="4" data-category="4" data-space="4.05"><a href="#" class="list__link">Hot Tub Festival</a></li>
					<li class="list__item" data-level="3" data-category="4" data-space="3.06"><a href="#" class="list__link">Feel the Grass</a></li>
                    */
     $html .= 
				'</ul>
			</aside>';
            
    return $html;
}		