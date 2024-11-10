<h1 align="center">Laravel Horizon tag search in pending and completed jobs</h1>

<p align="center">    
<img src="https://github.com/user-attachments/assets/a0e876b4-2c15-420c-a90b-f58857d8c33a" width="200" />
</p>

<p align="center">
<a href="https://github.com/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs/actions"><img src="https://github.com/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs"><img src="https://img.shields.io/packagist/dt/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs"><img src="https://img.shields.io/packagist/v/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs"><img src="https://img.shields.io/packagist/l/mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs" alt="License"></a>
</p>

## Introduction

This package allows searching for jobs in pending and completed states based on tags, similar to how it works for failed jobs.
Hopefully, this is a temporary package until this PR https://github.com/laravel/horizon/pull/1513 is merged.

## Screencast
https://github.com/user-attachments/assets/057da12b-c4d6-4947-a030-578714e9e0bd


## Installation
`composer require mvd81/laravel-horizon-tag-search-in-pending-and-completed-jobs`

If you have not yet installed Horizon, run `php artisan horizon:install` 

## What this package does

* Overrides the frontend to enable searching through pending and completed jobs.
* Creates listeners for the JobPushed and JobDeleted events to add and remove jobs in pending tags.
* Overrides the pending and completed job controllers to allow searching within pending and completed jobs.

## License

Laravel Horizon tag search in pending and completed jobs is open-sourced software licensed under the [MIT license](LICENSE.md).
