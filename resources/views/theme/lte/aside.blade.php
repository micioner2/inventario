<aside class="main-sidebar">
  <section class="sidebar">
  
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{asset("assets/$theme/dist/img/user2-160x160.jpg")}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
    
        <p>usuario</p>
 
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>

    <ul class="sidebar-menu" data-widget="tree">
  
      <li class="header">MENU</li>

      <li class="active" @click="menu=0">
          <a href="#">
              <i class="fa fa-home"></i> <span>Inicio</span>
          </a>
      </li>

      <li class="treeview">
          <a href="#">
              <i class="fa fa-shopping-cart"></i> <span>Inventario</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li @click="menu=5"><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Categorias / Productos</span></a></li>
          </ul>
      </li>

      <li class="treeview">
          <a href="#">
              <i class="fa fa-users"></i> <span>Usuarios</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li @click="menu=1"><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Empresa</span></a></li>
            <li @click="menu=2"><a href="#"><i class="fa fa-circle-o text-black"></i> <span>Usuarios</span></a></li>
            <li @click="menu=3"><a href="#"><i class="fa fa-circle-o text-green"></i> <span>Clientes</span></a></li>
            <li @click="menu=4"><a href="#"><i class="fa fa-circle-o text-default"></i> <span>Proveedores</span></a></li>
          </ul>
      </li>


      <li @click="menu=6"><a href="#"><i class="fa fa-circle-o text-blue"></i> <span>Compras</span></a></li>
      <li @click="menu=7"><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Ventas</span></a></li>
      <li class="treeview">
          <a href="#">
              <i class="fa fa-inbox"></i> <span>Administar</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li @click="menu=8"><a href="#"><i class="fa fa-circle-o"></i>Administrar Compras</a></li>
              <li @click="menu=9"><a href="#"><i class="fa fa-circle-o"></i>Administrar Ventas</a></li>
          </ul>
      </li>

    </ul>
  </section>
</aside>