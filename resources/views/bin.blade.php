<select class="form-control form-control-lg" name="bin">
    @foreach(App\Bins::all() as $bin)
      <option value="{{ $bin->ID }}" >{{ $bin->name }}</option>
    @endforeach
</select>
