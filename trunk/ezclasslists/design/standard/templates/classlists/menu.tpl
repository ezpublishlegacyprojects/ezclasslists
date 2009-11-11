{*
 * $Id$
 * $HeadURL$
 *}
<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h4>{'Options'|i18n( 'classlists/list' )}</h4>
</div></div></div></div></div></div>

<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">
    <form action={$page_uri|ezurl()} method="post" onsubmit="return classListsFilter({'classlists/list'|ezurl( 'single' )}, {'loader.gif'|ezimage( 'single' )})">
    {def $classlist = fetch( 'class', 'list', hash( 'class_filter', ezini( 'ListSettings', 'IncludeClasses', 'lists.ini' ),
                                                    'sort_by', array( 'name', true() ) ) )
         $uri = ''}
    <label for="classIdentifier">{'Classes list'|i18n( 'classlists/list' )}</label>
    <select name="classIdentifier" id="classIdentifier">
    {foreach $classlist as $class}
        <option value="{$class.identifier|wash()}"{cond( $class_identifier|eq( $class.identifier ), ' selected="selected"' , '' )}>{$class.name|wash()}</option>
    {/foreach}
    </select>
    {undef $classlist $uri}

    <label for="sortMethod">{'Sort by'|i18n( 'classlists/list' )}</label>
    {def $sort_methods = hash( 'depth', 'Depth',
                               'name', 'Name',
                               'path', 'Path',
                               'path_string', 'Path string',
                               'priority', 'Priority',
                               'modified', 'Modified',
                               'published', 'Published',
                               'section', 'Section' )}
    <select name="sortMethod" id="sortMethod">
        {foreach $sort_methods as $key => $sm}
        <option value="{$key}"
                       {cond( $key|eq( $sort_method ), ' selected="selected"', '' )}
                       title="{$sm|i18n( 'classlists/list' )}">{$sm|i18n( 'classlists/list' )|shorten( 20 )}</option>
        {/foreach}
    </select>
    {undef $sort_methods}


    <label for="sortOrder">{'Sort order'|i18n( 'classlists/list' )}</label>
    <select name="sortOrder" id="sortOrder">
        <option value="ascending"{cond( $sort_order, ' selected="selected"', '' )}>{'Ascending'|i18n( 'classlists/list' )}</option>
        <option value="descending"{cond( $sort_order|not, ' selected="selected"', '' )}>{'Descending'|i18n( 'classlists/list' )}</option>
    </select>
    <p>
        <input type="submit" class="button" value="{'Go'|i18n( 'classlists/list' )}" />
    </p>
    </form>
</div></div></div></div></div></div>
