@extends('backend.layouts.app')

@section('title')
Edit Role
@endsection
@section('content')
<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>Edit Role</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('roles.update',$role->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Name</label>
                        <div class="input-group">
                            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                type="text" placeholder="Name" autocomplete="off" value="{{ $role->name }}">
                        </div>
                        @error('name')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="container mt-2">
                        <h5 class="p-2 border-bottom">Permissions</h5>
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light text-black" aria-current="true">Categories</li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="categories_view">Show All Category</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="categories_view" name="permissions[]" @checked(in_array('categories_view',$permissions)) value="categories_view">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="categories_add">Create Category</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="categories_add" name="permissions[]" @checked(in_array('categories_add',$permissions)) value="categories_add">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="categories_edit">Edit Category</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="categories_edit" name="permissions[]" @checked(in_array('categories_edit',$permissions)) value="categories_edit">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="categories_delete">Delete Category</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="categories_delete" name="permissions[]" @checked(in_array('categories_delete',$permissions)) value="categories_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="categories_bulk_delete">Bulk Delete Category</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="categories_bulk_delete" name="permissions[]" @checked(in_array('categories_bulk_delete',$permissions)) value="categories_bulk_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light text-black" aria-current="true">Brands</li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="brands_view">Show All Brand</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="brands_view" name="permissions[]" @checked(in_array('brands_view',$permissions)) value="brands_view">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="brands_add">Create Brand</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="brands_add" name="permissions[]" @checked(in_array('brands_add',$permissions)) value="brands_add">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="brands_edit">Edit Brand</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="brands_edit" name="permissions[]" @checked(in_array('brands_edit',$permissions)) value="brands_edit">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="brands_delete">Delete Brand</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="brands_delete" name="permissions[]" @checked(in_array('brands_delete',$permissions)) value="brands_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="brands_bulk_delete">Bulk Delete Brand</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="brands_bulk_delete" name="permissions[]" @checked(in_array('brands_bulk_delete',$permissions)) value="brands_bulk_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light text-black" aria-current="true">Products</li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="products_view">Show All Product</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="products_view" name="permissions[]" @checked(in_array('products_view',$permissions)) value="products_view">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="products_publish">Product Publish </label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="products_publish" name="permissions[]" @checked(in_array('products_publish',$permissions)) value="products_publish">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="products_add">Create Product</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="products_add" name="permissions[]" @checked(in_array('products_add',$permissions)) value="products_add">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="products_edit">Edit Product</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="products_edit" name="permissions[]" @checked(in_array('products_edit',$permissions)) value="products_edit">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="products_delete">Delete Product</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="products_delete" name="permissions[]" @checked(in_array('products_delete',$permissions)) value="products_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="products_bulk_delete">Bulk Delete Product</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="products_bulk_delete" name="permissions[]" @checked(in_array('products_bulk_delete',$permissions)) value="products_bulk_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light text-black" aria-current="true">Attributes</li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="attributes_view">Show All Attribute</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="attributes_view" name="permissions[]" @checked(in_array('attributes_view',$permissions)) value="attributes_view">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="attributes_add">Create Attribute</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="attributes_add" name="permissions[]" @checked(in_array('attributes_add',$permissions)) value="attributes_add">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="attributes_edit">Edit Attribute</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="attributes_edit" name="permissions[]" @checked(in_array('attributes_edit',$permissions)) value="attributes_edit">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="attributes_delete">Delete Attribute</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="attributes_delete" name="permissions[]" @checked(in_array('attributes_delete',$permissions)) value="attributes_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light text-black" aria-current="true">Attribute Values</li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="attribute_value_view">Show All Attribute Values</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="attribute_value_view" name="permissions[]" @checked(in_array('attribute_value_view',$permissions)) value="attribute_value_view">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="attribute_value_add">Create Attribute Value</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="attribute_value_add" name="permissions[]" @checked(in_array('attribute_value_add',$permissions)) value="attribute_value_add">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="attribute_value_edit">Edit Attribute Value</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="attribute_value_edit" name="permissions[]" @checked(in_array('attribute_value_edit',$permissions)) value="attribute_value_edit">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="attribute_value_delete">Delete Attribute Value</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="attribute_value_delete" name="permissions[]" @checked(in_array('attribute_value_delete',$permissions)) value="attribute_value_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light text-black" aria-current="true">Orders</li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="orders_view">Show All Order</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="orders_view" name="permissions[]" @checked(in_array('orders_view',$permissions)) value="orders_view">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="orders_payment_status_change">Payment Status Change</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="orders_payment_status_change" name="permissions[]" @checked(in_array('orders_payment_status_change',$permissions)) value="orders_payment_status_change">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="orders_delivery_status_change">Delivery Status Change</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="orders_delivery_status_change" name="permissions[]" @checked(in_array('orders_delivery_status_change',$permissions)) value="orders_delivery_status_change">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="orders_delete">Delete Order</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="orders_delete" name="permissions[]" @checked(in_array('orders_delete',$permissions)) value="orders_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="orders_bulk_delete">Bulk Delete Order</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="orders_bulk_delete" name="permissions[]" @checked(in_array('orders_bulk_delete',$permissions)) value="orders_bulk_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light text-black" aria-current="true">Customers</li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="customers_view">Show All Customer</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="customers_view" name="permissions[]" @checked(in_array('customers_view',$permissions)) value="customers_view">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="customers_delete">Delete Customer</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="customers_delete" name="permissions[]" @checked(in_array('customers_delete',$permissions)) value="customers_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="customers_bulk_delete">Bulk Delete Customer</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="customers_bulk_delete" name="permissions[]" @checked(in_array('customers_bulk_delete',$permissions)) value="customers_bulk_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light text-black" aria-current="true">Pages</li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="page_view">Show Additional Pages</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="page_view" name="permissions[]" @checked(in_array('page_view',$permissions)) value="page_view">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="page_add">Add Page</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="page_add" name="permissions[]" @checked(in_array('page_add',$permissions)) value="page_add">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="page_edit">Edit Page</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="page_edit" name="permissions[]" @checked(in_array('page_edit',$permissions)) value="page_edit">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="page_delete">Delete Page</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="page_delete" name="permissions[]" @checked(in_array('page_delete',$permissions)) value="page_delete">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light text-black" aria-current="true">Settings</li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="home_page">Home Page</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="home_page" name="permissions[]" @checked(in_array('home_page',$permissions)) value="home_page">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="about_us_page">About Us Page</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="about_us_page" name="permissions[]" @checked(in_array('about_us_page',$permissions)) value="about_us_page">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="contact_us_page">Contact Us Page</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="contact_us_page" name="permissions[]" @checked(in_array('contact_us_page',$permissions)) value="contact_us_page">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="categories_menus">Categories Menu</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="categories_menus" name="permissions[]" @checked(in_array('categories_menus',$permissions)) value="categories_menus">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="system_settings">System Settings</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="system_settings" name="permissions[]" @checked(in_array('system_settings',$permissions)) value="system_settings">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="header_settings">Header Settings</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="header_settings" name="permissions[]" @checked(in_array('header_settings',$permissions)) value="header_settings">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="display_section_settings">Display Section</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="display_section_settings" name="permissions[]" @checked(in_array('display_section_settings',$permissions)) value="display_section_settings">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="footer_settings">Footer Settings</label> <br>
                                        <label class="switch">
                                            <input type="checkbox" id="footer_settings" name="permissions[]" @checked(in_array('footer_settings',$permissions)) value="footer_settings">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-success">Update Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
