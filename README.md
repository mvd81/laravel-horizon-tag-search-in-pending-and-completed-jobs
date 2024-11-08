# Laravel Horizon tag search in pending and completed jobs

Hopefully, this is a temporary package until this PR https://github.com/laravel/horizon/pull/1513 is merged. This package allows searching for jobs in pending
and completed states based on tags, similar to how it works for failed jobs.

## Installation
`composer require <todo>`

## What this package does

* Overrides the frontend to enable searching through pending and completed jobs.
* Creates listeners for the JobPushed and JobDeleted events to add and remove tags.
* Overrides the pending and completed job controllers to allow searching within pending and completed jobs.