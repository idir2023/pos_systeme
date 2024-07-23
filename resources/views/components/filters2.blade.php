  <div class="box @if(!empty($class)) {{$class}} @else box-solid @endif" id="accordion">
    <div class="box-header with-border" style="cursor: pointer;">
        <h3 class="box-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter2">
                @if(!empty($icon)) {!! $icon !!} @else <i class="fa fa-filter" aria-hidden="true"></i> @endif {{$title ?? ''}}
            </a>
        </h3>
    </div>
  
    @php
        // Set the $closed variable to true
        $closed = true;
    @endphp
  
    <div id="collapseFilter2" class="panel-collapse active collapse @if($closed) @else in @endif" aria-expanded="true">
        <div class="box-body">
            {{$slot}}
        </div>
    </div>
  </div>
  