<style>
    .country-btn{
        margin-top:0px !important;
    }
</style>
<style>

#notification-badge {
    font-size: 0.65rem;
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 5px;
    right:-3px;
    top:10px;
}

/* Pulse animation for new notifications */
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.pulse-badge {
    animation: pulse 2s infinite;
}

/* Make the bell icon slightly larger for better visibility */
.fa-bell {
    font-size: 1.8rem !important;
}
</style>

<style>
/* Badge animations */
@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    70% {
        transform: scale(1.1);
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}

.pulse-badge {
    animation: pulse 2s infinite;
    font-weight: bold;
}

/* Badge styles */
#notification-badge {
    font-size: 0.65rem;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 6px;
    border: 2px solid white;
    transform: translate(25%, -25%);
}

/* Notification bell with hover effect */
.notification-bell {
    position: relative;
    transition: all 0.3s ease;
}

.notification-bell:hover {
    transform: scale(1.1);
}

.notification-bell.shake {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(15deg); }
    75% { transform: rotate(-15deg); }
}

/* Status indicator for last update */
.last-update {
    font-size: 0.75rem;
    color: #6c757d;
    text-align: right;
    padding: 5px;
}
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light " data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container-fluid">
        <a class="navbar-brand d-inline-flex" href="{{ route('home') }}">
            <img class="d-inline-block" src="{{ asset('uploads/logo/logo5.png') }}" alt="logo"
                style="height: 4rem;" />
        </a>
        <div class="d-flex align-items-center">
            <a href="{{ route('business-service') }}" class="btn fs-1 text-dark btn-light d-md-flex align-items-center d-none">
                <i class="fa me-2 fa-building"></i> Corporate Ordering
            </a>
            <a href="{{ route('courier-service') }}" class="btn fs-1 text-dark btn-light d-md-flex align-items-center d-none">
                <i class="fa fw-bolder fs-1 me-2 fa-bicycle"></i>
                Become a courier
            </a>
            
            <!-- Notification Bell with Badge -->
            @if(Auth::check())
            <a href="{{ route('myaccount') }}?opt=notifications" class="btn btn-white text-dark me-2 position-relative">
                <i class="fa fa-bell fs-2"></i>
                @php
                    $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
                        ->where('is_read', false)
                        ->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="position-absolute  translate-middle badge rounded-pill bg-danger" 
                          id="notification-badge">
                        {{ $unreadCount }}
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                @endif
            </a>
            @endif
            
            <button class="country-btn" id="countryLangButton" data-bs-toggle="modal"
                data-bs-target="#countryLangModal">
                <img src="https://flagcdn.com/256x192/us.png" id="currentFlag" alt="Country Flag">
            </button>
            <button class="btn btn-white text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                type="button">
                <i class="fa fa-bars fs-2"></i>
            </button>
        </div>
    </div>
</nav>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-1">
            <div class="modal-header">
                <h5 class="modal-title fs-2 fw-bolder" id="staticBackdropLabel">My account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    @if (isset(auth()->user()->name))
                        <div class="col-md-6">
                            <a href="@if (auth()->user()->role == 'user') {{ route('myaccount') }}
                            @elseif (auth()->user()->role == 'vendor')
                                {{ route('vendor.dashboard') }}
                            @elseif (auth()->user()->role == 'admin')
                                {{ route('admin.dashboard') }} @endif"
                                class="btn btn-primary fw-bold fs-1   w-100">
                                <i class="fa fa-user" aria-hidden="true"></i> My Account
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('logout') }}" class="btn btn-light text-dark fw-bold fs-1  w-100">
                                <i class="fa fa-lock" aria-hidden="true"></i> Logout
                            </a>
                        </div>
                    @else
                        <div class="col-md-6">
                            <a href="{{ route('login') }}" class="btn btn-light fw-bold text-dark fs-1 w-100">
                                Sign in
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('register') }}" class="btn fs-1 btn-warning fw-bold w-100">
                                Create account
                            </a>
                        </div>
                    @endif

                    <div class="col-md-12 ">
                        <!-- Add Notifications link in the modal menu too -->
                        @if(Auth::check())
                        <a href="{{ route('myaccount') }}?opt=notifications" 
                           class="btn btn-light text-start fw-bold text-dark w-100 mt-3 fs-1 position-relative">
                            <i class="fa-solid fa-bell me-2"></i>
                            Notifications
                            @if($unreadCount > 0)
                                <span class="position-absolute top-50 end-0 translate-middle-y badge rounded-pill bg-danger me-3">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                        @endif
                        
                        <a href="{{ route('myaccount') }}?opt=orders" class="btn btn-light text-start fw-bold text-dark w-100 mt-3 fs-1">
                            <i class="fa-solid fa-bag-shopping me-2"></i>
                            Order
                        </a>
                        <a href="{{route('user.getFavoritesRestaurants')}}" class="btn btn-light text-start fw-bold text-dark w-100 mt-1 fs-1">
                            <i class="fa-regular fa-heart me-2"></i>
                            Favourites
                        </a>
                        <hr>
                        <a href="#" class="btn btn-light text-start fw-bold fw-bold w-100 text-dark mt-1 fs-1">
                            <i class="fa-solid fa-gift me-2"></i>
                            Punkte
                        </a>
                        <a href="#" class="btn btn-light d-flex align-items-center text-start fw-bold text-dark w-100 mt-1 fs-1">
                            <i class="fa-solid fa-percent me-2"></i>
                            StampCards
                        </a>
                        <a href="#" class="btn btn-light text-start w-100 fw-bold mt-1 text-dark fs-1">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            Need Help?
                        </a>
                        <a href="#" class="btn btn-light text-start w-100 fw-bold mt-1 text-dark fs-1">
                            <i class="fa-solid fa-gift me-2"></i>
                            Gift Cards
                        </a>
                        <hr>
                        <a href="{{ route('courier-service') }}" class="btn btn-light text-start w-100 text-dark fw-bold mt-1 fs-1">
                            <i class="fa-solid fa-bicycle me-2"></i>
                            Become a Courier
                        </a>
                        <a href="{{ route('business-service') }}" class="btn btn-light text-start w-100 text-dark fw-bold fs-1 mt-1">
                            <i class="fa-solid fa-building me-2"></i>
                            Corporat Ordering
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
// Configuration
const POLLING_CONFIG = {
    interval: 30000, // Check every 30 seconds (30,000ms)
    retryInterval: 5000, // Retry faster on error
    maxRetries: 3,
    // Check more frequently when user is active
    activeInterval: 15000,
    inactiveInterval: 60000
};

// State management
let pollingInterval = null;
let retryCount = 0;
let isTabActive = true;
let lastCheckedTime = null;

// Function to fetch unread count
function fetchUnreadCount() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '{{ route("notification-unread-count") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: '{{ Auth::id() }}'
            },
            timeout: 10000, // 10 second timeout
            success: function(response) {
                if(response.status) {
                    retryCount = 0; // Reset retry count on success
                    lastCheckedTime = response.last_checked;
                    resolve(response.unread_count);
                } else {
                    reject(new Error('Server error'));
                }
            },
            error: function(xhr, status, error) {
                reject(new Error('Network error: ' + error));
            }
        });
    });
}

// Update badge display
function updateBadgeDisplay(count) {
    const badgeElement = $('#notification-badge');
    const modalBadge = $('.modal .badge.bg-danger');
    
    if(count > 0) {
        // Show badge with count
        badgeElement.text(count > 99 ? '99+' : count);
        badgeElement.show();
        
        // Add pulse animation for new notifications
        if(!badgeElement.hasClass('pulse-badge')) {
            badgeElement.addClass('pulse-badge');
            
            // Also trigger browser notification if count increased
            if(window.Notification && Notification.permission === "granted") {
                showBrowserNotification(count);
            }
        }
        
        // Update modal badge
        modalBadge.text(count > 99 ? '99+' : count).show();
    } else {
        // Hide badge
        badgeElement.hide().removeClass('pulse-badge');
        modalBadge.hide();
    }
}

// Show browser notification (optional)
function showBrowserNotification(count) {
    if(document.hidden) { // Only if tab is not active
        const notification = new Notification('New Notifications', {
            body: `You have ${count} new notification${count > 1 ? 's' : ''}`,
            icon: '{{ asset("uploads/logo/logo5.png") }}',
            tag: 'foody-notifications'
        });
        
        notification.onclick = function() {
            window.focus();
            window.location.href = '{{ route("myaccount") }}?opt=notifications';
            this.close();
        };
    }
}

// Request browser notification permission
function requestNotificationPermission() {
    if(window.Notification && Notification.permission === "default") {
        Notification.requestPermission();
    }
}

// Main update function
async function updateNotificationBadge() {
    try {
        const count = await fetchUnreadCount();
        updateBadgeDisplay(count);
        
        // Adjust polling interval based on count
        adjustPollingInterval(count);
        
    } catch(error) {
        console.error('Failed to fetch notifications:', error);
        handlePollingError();
    }
}

// Smart polling adjustment
function adjustPollingInterval(count) {
    if(!isTabActive) {
        clearInterval(pollingInterval);
        pollingInterval = setInterval(updateNotificationBadge, POLLING_CONFIG.inactiveInterval);
        return;
    }
    
    // More frequent polling when there are notifications
    const newInterval = count > 0 ? POLLING_CONFIG.activeInterval : POLLING_CONFIG.interval;
    
    clearInterval(pollingInterval);
    pollingInterval = setInterval(updateNotificationBadge, newInterval);
}

// Error handling with exponential backoff
function handlePollingError() {
    retryCount++;
    
    if(retryCount >= POLLING_CONFIG.maxRetries) {
        console.log('Max retries reached. Stopping polling.');
        stopPolling();
        return;
    }
    
    // Exponential backoff: wait longer after each retry
    const backoffTime = POLLING_CONFIG.retryInterval * Math.pow(2, retryCount - 1);
    
    clearInterval(pollingInterval);
    setTimeout(() => {
        updateNotificationBadge();
        startPolling(); // Restart polling after successful retry
    }, backoffTime);
}

// Start/stop polling
function startPolling() {
    if(pollingInterval) clearInterval(pollingInterval);
    
    const initialInterval = isTabActive ? POLLING_CONFIG.interval : POLLING_CONFIG.inactiveInterval;
    pollingInterval = setInterval(updateNotificationBadge, initialInterval);
    
    console.log('Polling started with interval:', initialInterval);
}

function stopPolling() {
    if(pollingInterval) {
        clearInterval(pollingInterval);
        pollingInterval = null;
        console.log('Polling stopped');
    }
}

// Tab visibility management
function handleVisibilityChange() {
    isTabActive = !document.hidden;
    
    if(isTabActive) {
        // Tab became active, update immediately
        updateNotificationBadge();
        startPolling();
    } else {
        // Tab became inactive, slow down polling
        adjustPollingInterval(0);
    }
}

// Initialize everything
$(document).ready(function() {
    @if(Auth::check())
    // Request notification permission
    requestNotificationPermission();
    
    // Initial update
    updateNotificationBadge();
    
    // Start polling
    startPolling();
    
    // Set up visibility change listener
    document.addEventListener('visibilitychange', handleVisibilityChange);
    
    // Also poll when user interacts with page (optional)
    $(document).on('click scroll keydown', function() {
        if(!pollingInterval) {
            startPolling();
        }
    });
    
    // Clean up on page unload
    $(window).on('beforeunload', function() {
        stopPolling();
    });
    @endif
});

// Manual refresh function (can be called from other parts of your app)
function manuallyRefreshNotifications() {
    updateNotificationBadge();
}

// Update badge after marking as read (from previous code)
function markAsRead(notificationId) {
    $.ajax({
        url: '{{ route("notification-read") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: notificationId
        },
        success: function(response) {
            if(response.status) {
                // Update UI immediately
                $(`#notification-${notificationId}`).removeClass('unread-notification').addClass('read-notification');
                $(`#notification-${notificationId} .btn-success`).html('<i class="fa fa-check"></i> Read').removeClass('btn-success').addClass('btn-outline-success').prop('disabled', true);
                
                // Force refresh badge count
                updateNotificationBadge();
            }
        }
    });
}
</script>