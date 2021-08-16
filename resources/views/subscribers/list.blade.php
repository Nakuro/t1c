<form action="#" method="post" enctype="multipart/form-data"><input name="file" type="file"> <br>
    <button type="submit">Загрузить</button>
    <input name="_token" type="hidden" value="{{csrf_token()}}"></form>
@foreach($subscribers as $subscriber)
    {{$subscriber->email}} {{$subscriber->fio}}
    <a href="{{route('subscribers.sendEmail', ['subscriber'=>$subscriber->id])}}">отправить письмо</a><br>
@endforeach
{{$subscribers->links()}}