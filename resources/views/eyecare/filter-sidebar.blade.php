{{-- BEGIN:: Filter Sidebar --}}
<div class="filter-sidebar">
    {{-- filter menu --}}
    <form>
        @csrf
        <div class="filter-menu-wrapper">
            <div class="filter-close-btn">x</div>
            <div class="filter-heading-wrapper">
                <label>Filter</label>
                <span class="filter-toggler-icon"> <img src="{{asset('icon/arrow-down.png')}}" alt="down arrow"> </span>
            </div>

            <div class="form-group">
                <hr class="filter-hr">
                {{-- lenses case --}}
                <div class="form-check">
                    <input type="checkbox" id="1checkbox" name="Lenses Case" value="1" class="filter-checkbox"/>
                    <label for="lenses-case"> Lenses Case </label>
                </div>
                {{-- lashes box --}}
                <div class="form-check">
                    <input type="checkbox" id="1checkbox" name="Lenses Case" value="1" class="filter-checkbox"/>
                    <label for="lenses-case"> Lashes Box </label>
                </div>
                {{-- custom frame --}}
                <div class="form-check">
                    <input type="checkbox" id="1checkbox" name="Lenses Case" value="1" class="filter-checkbox"/>
                    <label for="lenses-case"> Custom Frame </label>
                </div>
                {{-- accessories box --}}
                <div class="form-check">
                    <input type="checkbox" id="1checkbox" name="Lenses Case" value="1" class="filter-checkbox"/>
                    <label for="lenses-case"> Accessories Box </label>
                </div>
            </div>

            <hr class="filter-hr" style="margin-left: 2em;">
            <div class="filter-reset-text text-center">
                <a class="cursor-pointer" id="clear-filter-btn">Reset Filter</a>
            </div>
        </div>
    </form>
</div>
{{-- END:: Filter Sidebar --}}