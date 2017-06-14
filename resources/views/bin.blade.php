<select class="form-control m-bot15" name="bin">
    @foreach(App\Bins::all() as $bin)
      <option value="{{ $bin->ID }}" >{{ $bin->name }}</option>
    @endforeach
</select>
