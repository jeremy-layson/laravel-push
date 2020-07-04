# laravel-push
**Author** Jeremy Layson
**Email** jeremy.b.layson@gmail.com
**Prepared for** Fourello, Inc.

# Usage
Publish the necessary files by running `php artisan vendor:publish`
Migrate the required tables (3 tables) by running `php artisan migrate`
In **app\Providers\AppServiceProviders** add the **app\Observers\PushObservers** to your main model (typically the User model)
The initial Observer should be able to add a User to the relevant topic upon changing (create, update and delete)
**Note:** The observer will not work if the data was added via mass insert.
For more information about observers visit https://laravel.com/docs/5.0/eloquent#model-events

# AWS
Aside from the environment variables `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY` and `AWS_DEFAULT_REGION` you should also have a `AWS_SNS_IOS_ARN` and `AWS_SNS_ANDROID_ARN`

# Extending
You can extend the capability of this by modifying the `App\Observers\PushObserver`
There are also raw functions that you can use from these files:
**JeremyLayson\Push\Libraries\Notify\Publish**
**JeremyLayson\Push\Libraries\Subscription\Device**
**JeremyLayson\Push\Libraries\Subscription\Topic**
**JeremyLayson\Push\Libraries\Topic\TopicManager**

# Subscribing
To automatically subscribe a model using their `device_id` you should pass the following parameters when creating, updating or deleting their model
`aws_push_device_id` (Device ID unique to each devices)
`aws_push_device_platform` (**android** or **ios** only, lower case)
`aws_push_device_mode` (**subscribe** or **unsubscribe** only)