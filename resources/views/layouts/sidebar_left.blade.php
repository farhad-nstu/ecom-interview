<nav class="mt-2">

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-item">
      <a href="{{url('admin/products')}}" class="nav-link {{ (request()->is('admin/products*')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-book col-md-2"></i>
        <p>Products</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="" class="nav-link">
        <i class="nav-icon fas fa-user-alt col-md-2"></i>
        <p class="col-md-10">Logout</p>
      </a>
    </li>
  </ul>

</nav>