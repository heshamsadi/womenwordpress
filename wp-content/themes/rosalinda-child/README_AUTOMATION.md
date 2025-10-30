# Recipe Automation Guide

**Complete guide for automated recipe posting via REST API and WP-CLI**

## 🎯 Overview

This guide shows how to programmatically create recipes using:
1. **WordPress REST API** - HTTP requests (cURL, Postman, Python, Node.js)
2. **WP-CLI** - Command-line scripts (PowerShell, Bash)

---

## 📋 Minimum Required Fields

To create a valid recipe that renders properly and validates with Google Rich Results:

### Absolutely Required (Will Fail Without)
- ✅ **Title** - Recipe name
- ✅ **Ingredients** - At least one ingredient (line-separated)

### Highly Recommended (For Good SEO)
- ⭐ **Featured Image** - Recipe photo
- ⭐ **Content** - Instructions
- ⭐ **Excerpt** - Short description

### Optional (Enhances Rich Results)
- 🔹 Cook Time
- 🔹 Prep Time
- 🔹 Servings
- 🔹 Calories
- 🔹 Nutritions
- 🔹 Cuisine
- 🔹 Course
- 🔹 Dietary Tags

---

## 🌐 REST API Automation

### Authentication

**Option 1: Application Passwords (Recommended)**
1. Go to: **Users → Profile**
2. Scroll to: **Application Passwords**
3. Name: "Recipe Bot"
4. Click: **Add New Application Password**
5. Copy the generated password (e.g., `abcd 1234 efgh 5678`)

**Option 2: Cookie Authentication**
- Use for same-domain requests
- Include `X-WP-Nonce` header

---

### Create Recipe (Two-Step Process)

#### Step 1: Create Recipe Post

**Endpoint:** `POST /wp-json/wp/v2/cpt_dishes`

**Headers:**
```http
Content-Type: application/json
Authorization: Basic <base64(username:app_password)>
```

**Request Body:**
```json
{
  "title": "Classic Chocolate Chip Cookies",
  "status": "publish",
  "excerpt": "Soft, chewy cookies with crispy edges and gooey centers.",
  "content": "<h3>Step 1: Prepare</h3><p>Preheat oven to 375°F.</p><h3>Step 2: Mix</h3><p>Combine dry ingredients.</p><h3>Step 3: Bake</h3><p>Bake 10-12 minutes until golden.</p>",
  "meta": {
    "trx_addons_options": {
      "ingredients": "2 cups all-purpose flour\n1 tsp baking soda\n1/2 tsp salt\n1 cup butter\n3/4 cup white sugar\n3/4 cup brown sugar\n2 large eggs\n2 tsp vanilla extract\n2 cups chocolate chips",
      "time": "10 minutes",
      "prep_time": "15 minutes",
      "servings": "24 cookies",
      "calories": "150",
      "nutritions": "Fat: 8g\nCarbs: 18g\nProtein: 2g",
      "cuisine": "American",
      "course": "Dessert",
      "difficulty": "Easy",
      "dietary_tags": "vegetarian"
    }
  }
}
```

**Response:**
```json
{
  "id": 123,
  "link": "https://yoursite.com/dishes/classic-chocolate-chip-cookies/",
  "title": {
    "rendered": "Classic Chocolate Chip Cookies"
  }
}
```

**Save the `id` for Step 2!**

---

#### Step 2: Upload Featured Image

**Endpoint:** `POST /wp-json/wp/v2/media`

**Headers:**
```http
Content-Disposition: attachment; filename="cookies.jpg"
Content-Type: image/jpeg
Authorization: Basic <base64(username:app_password)>
```

**Body:** Binary image data

**Query Parameters:**
```
?post={recipe_id}
```

**Response:**
```json
{
  "id": 456,
  "source_url": "https://yoursite.com/wp-content/uploads/2025/10/cookies.jpg"
}
```

**Then set as featured image:**

**Endpoint:** `POST /wp-json/wp/v2/cpt_dishes/{recipe_id}`

**Body:**
```json
{
  "featured_media": 456
}
```

---

### Complete cURL Examples

#### Linux/macOS/Git Bash

```bash
#!/bin/bash

# Configuration
SITE_URL="https://yoursite.local"
USERNAME="admin"
APP_PASSWORD="abcd 1234 efgh 5678"
AUTH=$(echo -n "$USERNAME:$APP_PASSWORD" | base64)

# Step 1: Create Recipe
echo "Creating recipe..."
RESPONSE=$(curl -s -X POST "$SITE_URL/wp-json/wp/v2/cpt_dishes" \
  -H "Authorization: Basic $AUTH" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Automated Chocolate Cake",
    "status": "publish",
    "excerpt": "Rich, moist chocolate cake made by a bot!",
    "content": "<h3>Step 1</h3><p>Mix ingredients.</p><h3>Step 2</h3><p>Bake at 350°F for 30 minutes.</p>",
    "meta": {
      "trx_addons_options": {
        "ingredients": "2 cups flour\n1.5 cups sugar\n3/4 cup cocoa powder\n2 tsp baking soda\n1 tsp baking powder\n1 tsp salt\n2 eggs\n1 cup milk\n1/2 cup vegetable oil\n2 tsp vanilla\n1 cup boiling water",
        "time": "30 minutes",
        "prep_time": "15 minutes",
        "servings": "12 slices",
        "calories": "350",
        "nutritions": "Fat: 12g\nCarbs: 55g\nProtein: 5g",
        "cuisine": "American",
        "course": "Dessert"
      }
    }
  }')

# Extract recipe ID
RECIPE_ID=$(echo $RESPONSE | grep -o '"id":[0-9]*' | grep -o '[0-9]*' | head -1)
echo "Recipe created with ID: $RECIPE_ID"

# Step 2: Upload Image
echo "Uploading image..."
IMAGE_RESPONSE=$(curl -s -X POST "$SITE_URL/wp-json/wp/v2/media?post=$RECIPE_ID" \
  -H "Authorization: Basic $AUTH" \
  -H "Content-Disposition: attachment; filename=cake.jpg" \
  -H "Content-Type: image/jpeg" \
  --data-binary "@/path/to/cake.jpg")

# Extract media ID
MEDIA_ID=$(echo $IMAGE_RESPONSE | grep -o '"id":[0-9]*' | grep -o '[0-9]*' | head -1)
echo "Image uploaded with ID: $MEDIA_ID"

# Step 3: Set Featured Image
echo "Setting featured image..."
curl -s -X POST "$SITE_URL/wp-json/wp/v2/cpt_dishes/$RECIPE_ID" \
  -H "Authorization: Basic $AUTH" \
  -H "Content-Type: application/json" \
  -d "{\"featured_media\": $MEDIA_ID}"

echo "✅ Recipe complete: $SITE_URL/wp-json/wp/v2/cpt_dishes/$RECIPE_ID"
```

---

#### PowerShell (Windows)

```powershell
# Configuration
$siteUrl = "https://yoursite.local"
$username = "admin"
$appPassword = "abcd 1234 efgh 5678"
$base64Auth = [Convert]::ToBase64String([Text.Encoding]::ASCII.GetBytes("${username}:${appPassword}"))

# Step 1: Create Recipe
Write-Host "Creating recipe..." -ForegroundColor Green

$headers = @{
    "Authorization" = "Basic $base64Auth"
    "Content-Type" = "application/json"
}

$body = @{
    title = "PowerShell Automated Recipe"
    status = "publish"
    excerpt = "Created by PowerShell automation"
    content = "<h3>Step 1</h3><p>Automated instructions.</p>"
    meta = @{
        trx_addons_options = @{
            ingredients = "Ingredient 1`nIngredient 2`nIngredient 3"
            time = "20 minutes"
            servings = "4 servings"
            calories = "200"
        }
    }
} | ConvertTo-Json -Depth 5

$response = Invoke-RestMethod -Uri "$siteUrl/wp-json/wp/v2/cpt_dishes" `
    -Method Post `
    -Headers $headers `
    -Body $body

$recipeId = $response.id
Write-Host "Recipe created with ID: $recipeId" -ForegroundColor Yellow

# Step 2: Upload Image
Write-Host "Uploading image..." -ForegroundColor Green

$imagePath = "C:\path\to\image.jpg"
$imageBytes = [System.IO.File]::ReadAllBytes($imagePath)
$imageHeaders = @{
    "Authorization" = "Basic $base64Auth"
    "Content-Type" = "image/jpeg"
    "Content-Disposition" = "attachment; filename=recipe.jpg"
}

$imageResponse = Invoke-RestMethod -Uri "$siteUrl/wp-json/wp/v2/media?post=$recipeId" `
    -Method Post `
    -Headers $imageHeaders `
    -Body $imageBytes

$mediaId = $imageResponse.id
Write-Host "Image uploaded with ID: $mediaId" -ForegroundColor Yellow

# Step 3: Set Featured Image
Write-Host "Setting featured image..." -ForegroundColor Green

$featuredBody = @{ featured_media = $mediaId } | ConvertTo-Json

Invoke-RestMethod -Uri "$siteUrl/wp-json/wp/v2/cpt_dishes/$recipeId" `
    -Method Post `
    -Headers $headers `
    -Body $featuredBody

Write-Host "✅ Recipe complete!" -ForegroundColor Green
Write-Host "View at: $siteUrl/dishes/" -ForegroundColor Cyan
```

---

### Python Example

```python
import requests
import base64
from pathlib import Path

# Configuration
SITE_URL = "https://yoursite.local"
USERNAME = "admin"
APP_PASSWORD = "abcd 1234 efgh 5678"

# Create auth header
credentials = f"{USERNAME}:{APP_PASSWORD}"
token = base64.b64encode(credentials.encode()).decode()
headers = {
    "Authorization": f"Basic {token}",
    "Content-Type": "application/json"
}

def create_recipe(title, ingredients, instructions, image_path=None):
    """Create a recipe via WordPress REST API"""
    
    # Step 1: Create recipe post
    recipe_data = {
        "title": title,
        "status": "publish",
        "excerpt": f"Delicious {title.lower()} recipe",
        "content": instructions,
        "meta": {
            "trx_addons_options": {
                "ingredients": ingredients,
                "time": "30 minutes",
                "servings": "4 servings",
                "calories": "250"
            }
        }
    }
    
    response = requests.post(
        f"{SITE_URL}/wp-json/wp/v2/cpt_dishes",
        headers=headers,
        json=recipe_data
    )
    
    if response.status_code not in [200, 201]:
        print(f"❌ Error creating recipe: {response.text}")
        return None
    
    recipe = response.json()
    recipe_id = recipe["id"]
    print(f"✅ Recipe created with ID: {recipe_id}")
    
    # Step 2: Upload image (if provided)
    if image_path and Path(image_path).exists():
        with open(image_path, "rb") as f:
            image_data = f.read()
        
        image_headers = {
            "Authorization": f"Basic {token}",
            "Content-Type": "image/jpeg",
            "Content-Disposition": f"attachment; filename={Path(image_path).name}"
        }
        
        image_response = requests.post(
            f"{SITE_URL}/wp-json/wp/v2/media?post={recipe_id}",
            headers=image_headers,
            data=image_data
        )
        
        if image_response.status_code in [200, 201]:
            media_id = image_response.json()["id"]
            print(f"✅ Image uploaded with ID: {media_id}")
            
            # Set as featured image
            requests.post(
                f"{SITE_URL}/wp-json/wp/v2/cpt_dishes/{recipe_id}",
                headers=headers,
                json={"featured_media": media_id}
            )
            print("✅ Featured image set")
    
    print(f"🎉 Recipe complete: {recipe['link']}")
    return recipe_id

# Example usage
if __name__ == "__main__":
    create_recipe(
        title="Python Automated Cookies",
        ingredients="2 cups flour\n1 cup sugar\n1/2 cup butter\n2 eggs",
        instructions="<h3>Step 1</h3><p>Mix ingredients.</p><h3>Step 2</h3><p>Bake.</p>",
        image_path="/path/to/cookies.jpg"
    )
```

---

### Node.js Example

```javascript
const axios = require('axios');
const fs = require('fs');
const FormData = require('form-data');

const SITE_URL = 'https://yoursite.local';
const USERNAME = 'admin';
const APP_PASSWORD = 'abcd 1234 efgh 5678';

const auth = {
    username: USERNAME,
    password: APP_PASSWORD
};

async function createRecipe(title, ingredients, instructions, imagePath) {
    try {
        // Step 1: Create recipe
        const recipeResponse = await axios.post(
            `${SITE_URL}/wp-json/wp/v2/cpt_dishes`,
            {
                title: title,
                status: 'publish',
                excerpt: `Delicious ${title.toLowerCase()}`,
                content: instructions,
                meta: {
                    trx_addons_options: {
                        ingredients: ingredients,
                        time: '25 minutes',
                        servings: '6 servings',
                        calories: '300'
                    }
                }
            },
            { auth }
        );
        
        const recipeId = recipeResponse.data.id;
        console.log(`✅ Recipe created with ID: ${recipeId}`);
        
        // Step 2: Upload image
        if (imagePath && fs.existsSync(imagePath)) {
            const form = new FormData();
            form.append('file', fs.createReadStream(imagePath));
            
            const imageResponse = await axios.post(
                `${SITE_URL}/wp-json/wp/v2/media?post=${recipeId}`,
                form,
                {
                    auth,
                    headers: form.getHeaders()
                }
            );
            
            const mediaId = imageResponse.data.id;
            console.log(`✅ Image uploaded with ID: ${mediaId}`);
            
            // Set featured image
            await axios.post(
                `${SITE_URL}/wp-json/wp/v2/cpt_dishes/${recipeId}`,
                { featured_media: mediaId },
                { auth }
            );
            
            console.log('✅ Featured image set');
        }
        
        console.log(`🎉 Recipe complete: ${recipeResponse.data.link}`);
        return recipeId;
        
    } catch (error) {
        console.error('❌ Error:', error.response?.data || error.message);
    }
}

// Example usage
createRecipe(
    'Node.js Automated Cake',
    '2 cups flour\n1.5 cups sugar\n3 eggs\n1 cup milk',
    '<h3>Step 1</h3><p>Mix.</p><h3>Step 2</h3><p>Bake.</p>',
    './cake.jpg'
);
```

---

## 🖥️ WP-CLI Automation

### Prerequisites

Install WP-CLI:
```bash
# Linux/macOS
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp

# Windows (via Composer)
composer global require wp-cli/wp-cli-bundle
```

---

### Bash Script (Linux/macOS/Git Bash)

```bash
#!/bin/bash

# Navigate to WordPress directory
cd /path/to/wordpress

# Create recipe post
RECIPE_ID=$(wp post create \
  --post_type=cpt_dishes \
  --post_title="WP-CLI Automated Recipe" \
  --post_status=publish \
  --post_excerpt="Created via WP-CLI" \
  --post_content="<h3>Step 1</h3><p>Mix ingredients.</p><h3>Step 2</h3><p>Bake.</p>" \
  --porcelain)

echo "Created recipe ID: $RECIPE_ID"

# Add ingredients meta
wp post meta update $RECIPE_ID "trx_addons_options" '{
  "ingredients": "2 cups flour\n1 cup sugar\n2 eggs",
  "time": "30 minutes",
  "servings": "8 servings",
  "calories": "200"
}' --format=json

# Import and set featured image
MEDIA_ID=$(wp media import /path/to/image.jpg \
  --post_id=$RECIPE_ID \
  --featured_image \
  --porcelain)

echo "✅ Recipe created with image: $MEDIA_ID"
echo "View: $(wp post list --post__in=$RECIPE_ID --field=url)"
```

---

### PowerShell Script (Windows)

```powershell
# Navigate to WordPress directory
Set-Location "C:\Users\YourUser\Local Sites\women1\app\public"

# Create recipe post
$recipeId = wp post create `
  --post_type=cpt_dishes `
  --post_title="PowerShell WP-CLI Recipe" `
  --post_status=publish `
  --post_excerpt="Automated via WP-CLI PowerShell" `
  --post_content="<h3>Step 1</h3><p>Instructions here.</p>" `
  --porcelain

Write-Host "Created recipe ID: $recipeId" -ForegroundColor Green

# Add meta data (ingredients)
$metaJson = @"
{
  "ingredients": "Ingredient 1`nIngredient 2`nIngredient 3",
  "time": "25 minutes",
  "servings": "6 servings",
  "calories": "250",
  "cuisine": "Italian",
  "course": "Main"
}
"@

wp post meta update $recipeId "trx_addons_options" $metaJson --format=json

# Upload and set featured image
$mediaId = wp media import "C:\path\to\image.jpg" `
  --post_id=$recipeId `
  --featured_image `
  --porcelain

Write-Host "✅ Recipe complete with image ID: $mediaId" -ForegroundColor Green
```

---

## 📦 Postman Collection

### Import into Postman

1. Create new Collection: "WordPress Recipe API"
2. Add Environment Variables:
   - `site_url`: `https://yoursite.local`
   - `username`: `admin`
   - `app_password`: `your_app_password_here`

### Request 1: Create Recipe

```
POST {{site_url}}/wp-json/wp/v2/cpt_dishes

Authorization: Basic (username:app_password)
Content-Type: application/json

Body (raw JSON):
{
  "title": "Postman Test Recipe",
  "status": "publish",
  "excerpt": "Testing via Postman",
  "content": "<h3>Step 1</h3><p>Instructions.</p>",
  "meta": {
    "trx_addons_options": {
      "ingredients": "Item 1\nItem 2\nItem 3",
      "time": "20 minutes",
      "servings": "4",
      "calories": "300"
    }
  }
}

Tests:
pm.environment.set("recipe_id", pm.response.json().id);
```

### Request 2: Upload Image

```
POST {{site_url}}/wp-json/wp/v2/media?post={{recipe_id}}

Authorization: Basic (username:app_password)
Content-Type: image/jpeg

Body: binary (select image file)

Tests:
pm.environment.set("media_id", pm.response.json().id);
```

### Request 3: Set Featured Image

```
POST {{site_url}}/wp-json/wp/v2/cpt_dishes/{{recipe_id}}

Authorization: Basic (username:app_password)
Content-Type: application/json

Body:
{
  "featured_media": {{media_id}}
}
```

---

## ✅ Testing & Validation

### 1. Test Recipe Creation

```bash
# Quick test via cURL
curl -X POST "https://yoursite.local/wp-json/wp/v2/cpt_dishes" \
  -u "admin:app_password_here" \
  -H "Content-Type: application/json" \
  -d '{"title":"Test","status":"publish","meta":{"trx_addons_options":{"ingredients":"Test ingredient"}}}'
```

### 2. Validate JSON-LD Schema

1. Create a recipe using any method above
2. Visit the recipe URL
3. View page source (Ctrl+U)
4. Find `<script type="application/ld+json">` in `<head>`
5. Copy JSON-LD content
6. Test at: **https://search.google.com/test/rich-results**

### 3. Check for Errors

```bash
# Enable WordPress debug logging
# In wp-config.php:
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

# Check logs
tail -f wp-content/debug.log
```

---

## 🚨 Troubleshooting

### "REST API disabled"
**Fix:** Check `.htaccess` or server config, ensure pretty permalinks enabled

### "401 Unauthorized"
**Fix:** Verify application password is correct, check Basic auth encoding

### "400 Bad Request - Invalid meta"
**Fix:** Ensure `meta.trx_addons_options` is a nested object, not a string

### "Featured image not showing"
**Fix:** Verify `featured_media` ID is correct, check image upload permissions

### "JSON-LD not outputting"
**Fix:** Ensure post is published, ingredients field is not empty

---

## 🎯 Minimal Working Example

**Absolute minimum for a valid recipe:**

```bash
curl -X POST "https://yoursite.local/wp-json/wp/v2/cpt_dishes" \
  -u "admin:your_app_password" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Quick Recipe",
    "status": "publish",
    "content": "Mix and bake.",
    "meta": {
      "trx_addons_options": {
        "ingredients": "Flour\nSugar\nEggs"
      }
    }
  }'
```

This will:
- ✅ Create a published recipe
- ✅ Render with template
- ✅ Output valid JSON-LD
- ✅ Pass Google Rich Results (basic)

---

## 📚 Additional Resources

- **WordPress REST API Handbook:** https://developer.wordpress.org/rest-api/
- **WP-CLI Commands:** https://developer.wordpress.org/cli/commands/
- **Schema.org Recipe:** https://schema.org/Recipe
- **Google Rich Results Test:** https://search.google.com/test/rich-results

---

**Ready to automate recipe creation!** 🤖🍪

For issues, check `wp-content/debug.log` or browser console.
