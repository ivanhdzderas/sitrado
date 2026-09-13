<?php
foreach ($submenu->getResult() as $key) {
	echo "   <br />&ensp;&ensp;&ensp;&ensp;&ensp;&ensp; SubMenu: ".str_replace('%20',' ',$key->nombre)."</h3>";
}
?>