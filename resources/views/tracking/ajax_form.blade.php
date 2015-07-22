<?php
$truckPictureUrl = $user->picture
        ? route('file.show', $user->file_id ?: 0)
        : route('file.show', $truck->file_id ?: 0);
?>

<div class="container-fluid">

    {!! link_to_route('truck.show',$user->surname . ' ' .
        $user->name,array('id' => $truck->id),
        array('class' => 'btn btn-link')) !!}

    @if (Auth::user()->is_admin == 1)
        {!! Form::model($truck,array('route' => array('truck.destroy',$truck->id),
        'class' => 'form-inline', 'method' => 'POST'))!!}

        {!! Form::submit('Удалить',
        array('class' => 'btn btn-link')) !!}

        {!! Form::close() !!}
    @endif

    <div class="form-group">
        <div class="col-md-4">
            <input type="image" class="pull-right" src="{{ $truckPictureUrl }}" height="80px" />
        </div>
        <div class="col-md-8">

            <p>Марка: {{ $truck->brand }} / {{ $truck->seria }}</p>
            <p>Гос.номер: {{ $truck->gos_number }}</p>
            <p>Статус: {{ $truck->status->description }}</p>
            <p>Местонахождение: {{ $user->track->city }}</p>
        </div>
    </div>


    <div class="form-group">
        <span class="col-md-4 text-right">Телефоны</span>
        <div class="col-md-8">
            {{ implode(",", $user->phones->lists('phone_number')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">

            @if($tracking)
                {!! Form::model($tracking,array("route" => array("tracking.destroy",$tracking->tracked_id),
                    'method' => 'POST','class' => 'form-inline')) !!}
                {!! Form::submit('Остановить отслеживание',array("id"=>"stop_tracking","class" => "btn btn-danger")) !!}
                {!! Form::close() !!}
            @else
                {!! Form::open(array("route" => "tracking.store")) !!}
                {!! Form::hidden("user_id",Auth::user()->id) !!}
                {!! Form::hidden("tracked_id",$user->id) !!}
                {!! Form::submit('Отслеживать',array("class" => "btn btn-primary")) !!}
                {!! Form::close() !!}
            @endif

        </div>
    </div>
</div>

