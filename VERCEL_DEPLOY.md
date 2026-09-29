# Vercel deployment checklist

This repository keeps the existing Laravel frontend unchanged. Vercel runs the Laravel backend through the community PHP runtime configured in `vercel.json`.

## Required Vercel environment variables

Set these in the Vercel project for **Production**, **Preview**, and **Development** as appropriate. Never commit their values:

```text
APP_ENV=production
APP_DEBUG=false
APP_KEY=<generate a strong Laravel key>
APP_URL=https://<your-domain>

DB_CONNECTION=mysql                 # or pgsql
DB_HOST=<managed-database-host>
DB_PORT=<database-port>
DB_DATABASE=<database-name>
DB_USERNAME=<database-user>
DB_PASSWORD=<database-password>

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr

FILESYSTEM_PUBLIC_DISK=s3
AWS_ACCESS_KEY_ID=<storage-key>
AWS_SECRET_ACCESS_KEY=<storage-secret>
AWS_DEFAULT_REGION=<storage-region>
AWS_BUCKET=<storage-bucket>
AWS_URL=<public-storage-url>
```

The database must be reachable over the public network or through a Vercel-supported private connection. Use a managed database provider rather than a database on a laptop or local network.

## First deployment

1. Create the Vercel project from this GitHub repository and keep the repository root as the project root.
2. Add the environment variables above in Vercel.
3. Deploy once.
4. Run migrations against the production database from a trusted machine or database host:

   ```bash
   php artisan migrate --force
   ```

5. Test login, API authentication, image uploads, and the `/up` health endpoint.

Uploads use the configured S3-compatible disk because Vercel function filesystems are not persistent. Keep `FILESYSTEM_PUBLIC_DISK=public` only for local development.

Do not set `APP_DEBUG=true` in Vercel and do not place database credentials, `APP_KEY`, or storage secrets in GitHub.
