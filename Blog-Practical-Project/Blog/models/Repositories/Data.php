<?php
namespace Models\Repositories;


class Data
{
    public static function users() {
        return new UsersData();
    }

    public static function problems() {
        return new ProblemsData();
    }

    public static function categories() {
        return new CategoriesData();
    }
} 