<div id="header" class="mdk-header js-mdk-header m-0" data-fixed data-effects="waterfall" data-retarget-mouse-scroll="false">
    <div class="mdk-header__content">

        <div class="navbar navbar-expand-sm navbar-main navbar-light bg-white  pr-0" id="navbar" data-primary>
            <div class="container-fluid p-0">

                <button class="navbar-toggler navbar-toggler-custom d-lg-none d-flex mr-navbar" type="button" data-toggle="sidebar">
                    <span class="material-icons">short_text</span>
                </button>

                <p class="navbar-brand mb-0 flex">
                    <span>{{ $title }}</span>
                </p>

                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" data-caret="false" class="dropdown-toggle navbar-toggler navbar-toggler-company border-left d-flex align-items-center ml-navbar">
                        <span class="rounded-circle">
                            <img src="@if(auth()->user()->image == 'default.png') {{ asset('img/default.png') }} @else {{ asset('storage/images/'.auth()->user()->image) }} @endif" width="43" height="43" style="border-radius: 100%" alt="avatar">
                        </span>
                    </a>
                    <div id="company_menu" class="dropdown-menu dropdown-menu-right navbar-company-menu">
                        <div class="dropdown-item d-flex align-items-center py-2 navbar-company-info py-3">

                            <span class="mr-3">
                                <img src="@if(auth()->user()->image == 'default.png') {{ asset('img/default.png') }} @else {{ asset('storage/images/'.auth()->user()->image) }} @endif" width="43" height="43" style="border-radius: 100%" alt="avatar">
                            </span>
                            
                            <span class="flex d-flex flex-column">
                                <strong style="font-size: 1.125rem;">{{ auth()->user()->username }}</strong>
                                <small class="text-muted text-uppercase">{{ auth()->user()->level }}</small>
                            </span>

                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item @if($id_page == 8) active @endif d-flex align-items-center py-2" href="/setting/edit_profil">
                            <span class="material-icons mr-2">settings</span> Edit Profil
                        </a>
                        
                        <div class="dropdown-divider"></div>

                        <form action="{{ route('handleLogout') }}" method="POST">
                            @csrf     
                            <button type="submit" class="dropdown-item d-flex align-items-center py-2" href="#">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>