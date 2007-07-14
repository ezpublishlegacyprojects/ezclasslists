<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h4>{'Classes list'|i18n( 'classlists/list' )}</h4>
</div></div></div></div></div></div>

<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">
<ul>
	{def $classlist=fetch(class, list)
		 $uri=''
	}
	{foreach $classlist as $class}
	{set $uri=concat('classlists/list/', $class.identifier)|ezurl('no')}
	<li{if $module_result.uri|eq($uri)} class="class_selected"{/if}><div><a href="{$uri}"><span>{$class.name}</span></a></div></li>
	{/foreach}
	{undef $classlist $uri}
</ul>

</div></div></div></div></div></div>
