<p align="center">
<a href="https://github.com/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs/actions"><img src="https://github.com/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs"><img src="https://img.shields.io/packagist/dt/laravel/horizon" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs"><img src="https://img.shields.io/packagist/v/laravel/horizon" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs"><img src="https://img.shields.io/packagist/l/laravel/horizon" alt="License"></a>
</p>

## Introduction

This package allows searching for jobs in pending and completed states based on tags, similar to how it works for failed jobs.
Hopefully, this is a temporary package until this PR https://github.com/laravel/horizon/pull/1513 is merged. 

## Installation
`composer require mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs`

## What this package does

* Overrides the frontend to enable searching through pending and completed jobs.
* Creates listeners for the JobPushed and JobDeleted events to add and remove jobs in pending tags.
* Overrides the pending and completed job controllers to allow searching within pending and completed jobs.

## License

Laravel Horizon tag search in pending and completed jobs is open-sourced software licensed under the [MIT license](LICENSE.md).