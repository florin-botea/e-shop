<nav id="column-left">
  <div id="navigation">
      <span class="fa fa-bars"></span> {{ $text_navigation }}
  </div>
  <ul id="menu">
    <li p-foreach="(array)$menus as $i => $menu" :id="$menu->id">
      <a p-if="$menu->href" :href="$menu->href"><i :class="'fa '.$menu->icon.' fw'"></i> {{ $menu->name }}</a>
      <a p-else :href="'#collapse'.$i" data-toggle="collapse" class="parent collapsed"><i :class="'fa '.$menu.icon.' fw'"></i> {{ $menu->name }}</a>
      <ul p-if="$menu->children" :id="'collapse'.$i" class="collapse">
        <li p-foreach="$menu->children as $j => $children_1">
          <a p-if="$children_1->href" :href="$children_1->href">{{ $children_1->name }}</a>
          <a p-else :href="'#collapse'.$i.'-'.$j" data-toggle="collapse" class="parent collapsed">{{ $children_1->name }}</a>
          <ul p-if="$children_1->children" :id="'collapse'.$i.'-'.$j" class="collapse">
            <li p-foreach="$children_2->children as $k => $children_2">
              <a p-if="$children_2->href" :href="$children_2->href">{{ $children_2->name }}</a>
              <a p-else :href="'#collapse-'.$i.'-'.$j.'-'.$k" data-toggle="collapse" class="parent collapsed">{{ $children_2->name }}</a>
              <ul p-if="$children_2->children" :id="'collapse-'. $i .'-'. $j .'-'. $k" class="collapse">
                <li p-foreach="$children_2->children as $children_3"><a :href="$children_3->href">{{ $children_3->name }}</a></li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</nav>
