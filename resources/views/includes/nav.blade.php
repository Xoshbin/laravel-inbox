<nav>
    <router-link to="/compose" class="btn btn-danger btn-block">New Email</router-link>
    <ul class="nav">
        <li class="nav-item">
            <router-link class="nav-link" to="/dashboard">
                <i class="fa fa-inbox"></i> Inbox
                <span class="badge badge-danger">{{ $emailCount }}</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/starred">
                <i class="fa fa-star"></i> Stared
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/sent"><i class="fa fa-rocket"></i> Sent</router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/trash"><i class="fas fa-trash"></i> Trash</router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/important"><i class="fa fa-bookmark"></i> Important</router-link>
        </li>
    </ul>
</nav>