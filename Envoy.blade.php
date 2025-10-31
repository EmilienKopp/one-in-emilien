@servers(['local' => '127.0.0.1'])

@setup
    $devDir = '/home/ec2k/code/one-in-emilien';
    $prodDir = '/var/www/portfolio';
    $startTime = time();
@endsetup

@story('deploy')
    sync
    install_dependencies
    build_assets
    migrate
    optimize
    restart
    cleanup
@endstory

@task('sync')
    echo "📦 Syncing files..."
    rsync -av --delete --exclude '.git' \
    --exclude 'node_modules' \
    --exclude 'vendor' \
    --exclude '.env' \
    --exclude 'storage/logs/*' \
    --exclude 'storage/framework/cache/*' \
    --exclude 'storage/framework/sessions/*' \
    --exclude 'storage/framework/views/*' \
    --exclude 'compose.yaml' \
    --exclude 'Envoy.blade.php' \
    {{ $devDir }}/ {{ $prodDir }}/
    echo "✅ Files synced!"

    cd {{ $prodDir }} && chown -R 1000:1000 storage bootstrap/cache resources public
@endtask

@task('install_dependencies')
    echo "🔧 Installing Composer dependencies..."
    composer install --optimize-autoloader --ignore-platform-reqs
    cd {{ $prodDir }} && ./vendor/bin/sail npm ci
@endtask

@task('build_assets')
    echo "🎨 Generating Wayfinder types..."
    cd {{ $prodDir }} && ./vendor/bin/sail artisan wayfinder:generate --with-form
    echo "🎨 Building assets..."
    cd {{ $prodDir }} && ./vendor/bin/sail npm run build
@endtask

@task('migrate')
    echo "🔄 Running migrations..."
    cd {{ $prodDir }} && ./vendor/bin/sail artisan migrate --force
@endtask

@task('optimize')
    echo "⚡ Optimizing..."
    cd {{ $prodDir }} && ./vendor/bin/sail artisan optimize
@endtask

@task('restart')
    echo "♻️  Restarting..."
    cd {{ $prodDir }} && ./vendor/bin/sail restart
@endtask

@task('cleanup')
    echo "🧹 Cleaning up..."
    chown -R 1000:1000 {{ $prodDir }}/storage {{ $prodDir }}/bootstrap/cache {{ $prodDir }}/resources {{ $prodDir }}/public
    echo "✅ Done!"
@endtask

@finished
    $duration = time() - $startTime;
    $formatted = \Carbon\CarbonInterval::seconds($duration)->cascade()->forHumans();
    echo "⏱ Deployment took: {$formatted}\n";
    echo "🎉 Deployment finished successfully!\n";
@endfinished