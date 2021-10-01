<div class="col-md-3" >
    <form action="{{ url($bUrl) }}" method="post"  class="form-inline">
        @csrf
        <div class="form-row">
            <div class="col">
                <select class="form-control" name="per_page" id="per_page" class="form-control">

                    <option value=""> Per page </option>
                    @php
                        $perPageRecords = [2,5,15,20,30];
                    @endphp
                    @foreach ($perPageRecords as $p)
                        <option value="{{ $p }}"  {{ session('per_page') == $p ? 'selected' : '' }} >{{ $p }}</option>
                    @endforeach;

                </select>
            </div>	<!--/form-row-->

        </div>


    </form>
</div>
