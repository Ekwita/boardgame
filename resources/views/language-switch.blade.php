<form action="{{route('language.switch')}}" method="post">
@csrf
<select name="language" onchange="this.form.submit()" id="" class="text-gray-300 bg-black">
    <option value="en"{{app()->getLocale() === 'en' ? 'selected' : ''}}>English</option>
    <option value="pl"{{app()->getLocale() === 'pl' ? 'selected' : ''}}>Polish</option>
</select>

</form>