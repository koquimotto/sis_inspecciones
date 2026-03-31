
<header class="app-header">
    <nav class="main-header !h-[3.75rem]" aria-label="Global">
        <div class="main-header-container ps-[0.725rem] pe-[1rem] ">

            <div class="header-content-left">
                <!-- Start::header-element -->
                <div class="header-element">
                <div class="horizontal-logo">
                    <a href="{{url('index')}}" class="header-logo">
                    <img src="{{asset('build/assets/images/brand-logos/desktop-logo.png')}}" alt="logo" class="desktop-logo">
                    <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" alt="logo" class="toggle-logo">
                    <img src="{{asset('build/assets/images/brand-logos/desktop-dark.png')}}" alt="logo" class="desktop-dark">
                    <img src="{{asset('build/assets/images/brand-logos/toggle-dark.png')}}" alt="logo" class="toggle-dark">
                    <img src="{{asset('build/assets/images/brand-logos/desktop-white.png')}}" alt="logo" class="desktop-white">
                    <img src="{{asset('build/assets/images/brand-logos/toggle-white.png')}}" alt="logo" class="toggle-white">
                    </a>
                </div>
                </div>
                <!-- End::header-element -->
                <!-- Start::header-element -->
                <div class="header-element md:px-[0.325rem] !items-center">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar"
                    class="sidemenu-toggle animated-arrow  hor-toggle horizontal-navtoggle inline-flex items-center" href="javascript:void(0);"><span></span></a>
                <!-- End::header-link -->
                </div>
                <!-- End::header-element -->
            </div>

            <div class="header-content-right">

                <!-- light and dark theme -->
                <div class="header-element header-theme-mode hidden !items-center sm:block !py-[1rem] md:!px-[0.65rem] px-2">
                    <a aria-label="anchor"
                        class="hs-dark-mode-active:hidden flex hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium transition-all text-xs"
                        href="javascript:void(0);" data-hs-theme-click-value="dark">
                        <i class="bx bx-moon header-link-icon"></i>
                    </a>
                    <a aria-label="anchor"
                        class="hs-dark-mode-active:flex hidden hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium text-defaulttextcolor  transition-all text-xs"
                        href="javascript:void(0);" data-hs-theme-click-value="light">
                        <i class="bx bx-sun header-link-icon"></i>
                    </a>
                </div>
                <!-- End light and dark theme -->


                <!--Header Notifictaion -->
                <div class="header-element py-[1rem] md:px-[0.65rem] px-2 notifications-dropdown header-notification hs-dropdown ti-dropdown !hidden md:!block [--placement:bottom-left]">
                    <button id="dropdown-notification" type="button"
                        class="hs-dropdown-toggle relative ti-dropdown-toggle !p-0 !border-0 flex-shrink-0  !rounded-full !shadow-none align-middle text-xs">
                        <i class="bx bx-bell header-link-icon  text-[1.125rem]"></i>
                        <span class="flex absolute h-5 w-5 -top-[0.25rem] end-0  -me-[0.6rem]">
                        <span
                            class="animate-slow-ping absolute inline-flex -top-[2px] -start-[2px] h-full w-full rounded-full bg-secondary/40 opacity-75"></span>
                        <span
                            class="relative inline-flex justify-center items-center rounded-full  h-[14.7px] w-[14px] bg-secondary text-[0.625rem] text-white"
                            id="notification-icon-badge">5</span>
                        </span>
                    </button>
                    <div class="main-header-dropdown !-mt-3 !p-0 hs-dropdown-menu ti-dropdown-menu bg-white !w-[22rem] border-0 border-defaultborder hidden !m-0"
                        aria-labelledby="dropdown-notification">

                        <div class="ti-dropdown-header !m-0 !p-4 !bg-transparent flex justify-between items-center">
                        <p class="mb-0 text-[1.0625rem] text-defaulttextcolor font-semibold">Notifications</p>
                        <span class="text-[0.75em] py-[0.25rem/2] px-[0.45rem] font-[600] rounded-sm bg-secondary/10 text-secondary"
                            id="notifiation-data">5 Unread</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <ul class="list-none !m-0 !p-0 end-0" id="header-notification-scroll">
                        <li class="ti-dropdown-item dropdown-item !block">
                            <div class="flex items-start">
                            <div class="pe-2">
                                <span
                                class="inline-flex text-primary justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem] !bg-primary/10 !rounded-[50%]"><i
                                    class="ti ti-gift text-[1.125rem]"></i></span>
                            </div>
                            <div class="grow flex items-center justify-between">
                                <div>
                                <p class="mb-0 text-defaulttextcolor text-[0.8125rem] font-semibold"><a
                                    href="{{url('notifications')}}">Your Order Has Been Shipped</a></p>
                                <span class="text-[#8c9097] font-normal text-[0.75rem] header-notification-text">Order No: 123456
                                    Has Shipped To Your Delivery Address</span>
                                </div>
                                <div>
                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                                </div>
                            </div>
                            </div>
                        </li>
                        <li class="ti-dropdown-item dropdown-item !block">
                            <div class="flex items-start">
                            <div class="pe-2">
                                <span
                                class="inline-flex text-secondary justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-secondary/10 rounded-[50%]"><i
                                    class="ti ti-discount-2 text-[1.125rem]"></i></span>
                            </div>
                            <div class="grow flex items-center justify-between">
                                <div>
                                <p class="mb-0 text-defaulttextcolor text-[0.8125rem]  font-semibold"><a
                                    href="{{url('notifications')}}">Discount Available</a></p>
                                <span class="text-[#8c9097] font-normal text-[0.75rem] header-notification-text">Discount
                                    Available On Selected Products</span>
                                </div>
                                <div>
                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit  text-[#8c9097] me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                                </div>
                            </div>
                            </div>
                        </li>
                        <li class="ti-dropdown-item dropdown-item !block">
                            <div class="flex items-start">
                            <div class="pe-2">
                                <span
                                class="inline-flex text-pinkmain justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-pinkmain/10 rounded-[50%]"><i
                                    class="ti ti-user-check text-[1.125rem]"></i></span>
                            </div>
                            <div class="grow flex items-center justify-between">
                                <div>
                                <p class="mb-0 text-defaulttextcolor text-[0.8125rem]  font-semibold"><a
                                    href="{{url('notifications')}}">Account Has Been Verified</a></p>
                                <span class="text-[#8c9097] font-normal text-[0.75rem] header-notification-text">Your Account Has
                                    Been Verified Sucessfully</span>
                                </div>
                                <div>
                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                                </div>
                            </div>
                            </div>
                        </li>
                        <li class="ti-dropdown-item dropdown-item !block">
                            <div class="flex items-start">
                            <div class="pe-2">
                                <span
                                class="inline-flex text-warning justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-warning/10 rounded-[50%]"><i
                                    class="ti ti-circle-check text-[1.125rem]"></i></span>
                            </div>
                            <div class="grow flex items-center justify-between">
                                <div>
                                <p class="mb-0 text-defaulttextcolor text-[0.8125rem]  font-semibold"><a
                                    href="{{url('notifications')}}">Order Placed <span class="text-warning">ID: #1116773</span></a></p>
                                <span class="text-[#8c9097] font-normal text-[0.75rem] header-notification-text">Order Placed
                                    Successfully</span>
                                </div>
                                <div>
                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                                </div>
                            </div>
                            </div>
                        </li>
                        <li class="ti-dropdown-item dropdown-item !block">
                            <div class="flex items-start">
                            <div class="pe-2">
                                <span
                                class="inline-flex text-success justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-success/10 rounded-[50%]"><i
                                    class="ti ti-clock text-[1.125rem]"></i></span>
                            </div>
                            <div class="grow flex items-center justify-between">
                                <div>
                                <p class="mb-0 text-defaulttextcolor  text-[0.8125rem]  font-semibold"><a
                                    href="{{url('notifications')}}">Order Delayed <span class="text-success">ID: 7731116</span></a></p>
                                <span class="text-[#8c9097] font-normal text-[0.75rem] header-notification-text">Order Delayed
                                    Unfortunately</span>
                                </div>
                                <div>
                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                                </div>
                            </div>
                            </div>
                        </li>
                        </ul>

                        <div class="p-4 empty-header-item1 border-t mt-2">
                        <div class="grid">
                            <a href="{{url('notifications')}}" class="ti-btn ti-btn-primary-full !m-0 w-full p-2">View All</a>
                        </div>
                        </div>
                        <div class="p-[3rem] empty-item1 hidden">
                        <div class="text-center">
                            <span class="!h-[4rem]  !w-[4rem] avatar !leading-[4rem] !rounded-full !bg-secondary/10 !text-secondary">
                            <i class="ri-notification-off-line text-[2rem]  "></i>
                            </span>
                            <h6 class="font-semibold mt-3 text-defaulttextcolor text-[1rem]">No New Notifications</h6>
                        </div>
                        </div>
                    </div>
                </div>
                <!--End Header Notifictaion -->



                <!-- Fullscreen -->
                <div class="header-element header-fullscreen py-[1rem] md:px-[0.65rem] px-2">
                <!-- Start::header-link -->
                <a aria-label="anchor" onclick="openFullscreen();" href="javascript:void(0);"
                    class="inline-flex flex-shrink-0 justify-center items-center gap-2  !rounded-full font-medium">
                    <i class="bx bx-fullscreen full-screen-open header-link-icon"></i>
                    <i class="bx bx-exit-fullscreen full-screen-close header-link-icon hidden"></i>
                </a>
                <!-- End::header-link -->
                </div>
                <!-- End Full screen -->

                <!-- Header Profile -->
                <div class="header-element md:!px-[0.65rem] px-2 hs-dropdown !items-center ti-dropdown [--placement:bottom-left]">

                @php($authUser = Auth::user())
                <button id="dropdown-profile" type="button"
                    class="hs-dropdown-toggle ti-dropdown-toggle !gap-2 !p-0 flex-shrink-0 sm:me-2 me-0 !rounded-full !shadow-none text-xs align-middle !border-0 !shadow-transparent ">
                    <img class="inline-block rounded-full "
                        src="{{ !empty($authUser?->avatar) ? URL::asset('images/' . $authUser->avatar) : URL::asset('img/user.jpg') }}"
                        width="32" height="32" alt="Image Description">
                </button>
                <div class="md:block hidden dropdown-profile">
                    <p class="font-semibold mb-0 leading-none text-[#536485] text-[0.813rem] ">{{ $authUser?->name ?? 'Usuario' }}</p>
                    <span class="opacity-[0.7] font-normal text-[#536485] block text-[0.6875rem] ">Web Designer</span>
                </div>
                <div
                    class="hs-dropdown-menu ti-dropdown-menu !-mt-3 border-0 w-[11rem] !p-0 border-defaultborder hidden main-header-dropdown  pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="dropdown-profile">

                    <ul class="text-defaulttextcolor font-medium">
                    <li>
                        <a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0  !p-[0.65rem] !inline-flex" href="{{url('profile')}}">
                        <i class="ti ti-user-circle text-[1.125rem] me-2 opacity-[0.7]"></i>Profile
                        </a>
                    </li>
                    <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex" href="{{url('chat')}}"><i
                            class="ti ti-headset text-[1.125rem] me-2 opacity-[0.7]"></i>Support</a></li>
                    <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="ti ti-logout text-[1.125rem] me-2 opacity-[0.7]"></i>Log Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>        
                    </li>
                    </ul>
                </div>
                </div>
                <!-- End Header Profile -->
            </div>
        </div>
    </nav>
</header>
