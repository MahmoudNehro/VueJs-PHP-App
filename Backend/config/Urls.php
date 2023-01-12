<?php

namespace Config;

enum Urls: string
{
    case PRODUCTS = "products";
    case PRODUCTS_DELETE = "products/delete";
    case CATEGORIES = "categories";
    case CATEGORY = "categories/category";
}
