<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'freeCrystal');
$eqLogics = eqLogic::byType('freeCrystal');
?>
<div class="row row-overflow">
    <div class="col-md-2">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <?php
                foreach ($eqLogics as $eqLogic) {
					echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
	<div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
        <legend>{{Mes informations Freebox}}
        </legend>
        <?php
        if (count($eqLogics) == 0) {
            echo "<br/><br/><br/><center><span style='color:#767676;font-size:1.2em;font-weight: bold;'>{{Aucun equipement n'a été créer.}} <br/>{{Veuillez D
			désactuiver puis re-activer le plugin pour la création automatique des équipement}}</span></center>";
        } else {
            ?>
            <div class="eqLogicThumbnailContainer">
                <?php
                foreach ($eqLogics as $eqLogic) {
                    echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
                    echo "<center>";
                    echo '<img src="plugins/freeCrystal/doc/images/freeCrystal_icon.png" height="105" width="95" />';
                    echo "</center>";
                    echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
                    echo '</div>';
                }
                ?>
            </div>
        <?php } ?>
    </div>
    <div class="col-md-10 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
        <form class="form-horizontal">
            <fieldset>
				<legend>
						<i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> Général  
						<i class="fa fa-cogs eqLogicAction pull-right cursor expertModeVisible" data-action="configure"></i>
						<a class="btn btn-default btn-xs pull-right expertModeVisible eqLogicAction" data-action="copy"><i class="fa fa-copy"></i>Dupliquer</a>
						<a class="btn btn-success btn-xs eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> Sauvegarder</a>
						<a class="btn btn-danger btn-xs eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> Supprimer</a>
				</legend>
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Nom}}</label>
                    <div class="col-md-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                        <input type="text" class="eqLogicAttr form-control" data-l1key="logicalId" style="display : none;" />
                        <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de la Freebox Serveur}}"/>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-2 control-label" >{{Objet parent}}</label>
                    <div class="col-md-3">
                        <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                            <option value="">{{Aucun}}</option>
                            <?php
                            foreach (object::all() as $object) {
                                echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Catégorie}}</label>
                    <div class="col-md-8">
                        <?php
                        foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                            echo '<label class="checkbox-inline">';
                            echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                            echo '</label>';
                        }
                        ?>

                    </div>
                </div>  
				<div class="form-group">
					<label class="col-sm-2 control-label" ></label>
					<div class="col-sm-9">
						<label>{{Activer}}</label>
						<input type="checkbox" class="eqLogicAttr" data-label-text="{{Activer}}" data-l1key="isEnable" checked/>
						<label>{{Visible}}</label>
						<input type="checkbox" class="eqLogicAttr" data-label-text="{{Visible}}" data-l1key="isVisible" checked/>
					</div>
				</div>	
			</fieldset> 
        </form>
        <legend>{{Information}}</legend>
        <div id="table_freeCrystal"></div>
        <form class="form-horizontal">
            <fieldset>
                <div class="form-actions">
                    <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
                    <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<?php include_file('desktop', 'freeCrystal', 'js' , 'freeCrystal'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
