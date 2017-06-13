<select class="form-control m-bot15" name="bin">
    @foreach($bins as $bin)
      <option value="{{ $bin->ID }}" >{{ $bin->name }}</option>
    @endforeach
</select>
