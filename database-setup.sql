-- Culinaire Database Setup Script
-- Run this script in MySQL to create the database and tables

-- Create database
CREATE DATABASE IF NOT EXISTS culinaire_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Use the database
USE culinaire_db;

-- Create blogs table
CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    excerpt TEXT NOT NULL,
    content TEXT NOT NULL,
    thumbnail_path VARCHAR(255) NOT NULL,
    banner_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert existing blog posts
-- Note: Make sure to copy blog images to uploads/blogs/thumbnails/ and uploads/blogs/banners/ first!
INSERT INTO blogs (slug, title, author, excerpt, content, thumbnail_path, banner_path, created_at)
VALUES
('kitchen-hacks', 'Kitchen Hacks', 'Adrian Esguerra',
 'Discover ingenious shortcuts and techniques to streamline your cooking process. Learn how to chop vegetables faster, prevent food from sticking to pans, and make the most of your leftovers.',
 '<p>Kitchen hacks can save time and effort while cooking, making meal prep smoother and more enjoyable. For example, peeling garlic can be tedious, but smashing the clove with the flat side of a knife quickly loosens the skin for easy removal. If your bread goes stale, don''t throw it away—just sprinkle it with water and bake for 5-10 minutes to revive its fresh, crusty texture. Small adjustments like these can reduce waste and make common kitchen tasks faster.</p><p>Other useful hacks include keeping herbs fresh by storing them in a glass of water, loosely covered with a plastic bag, which helps them last longer. You can also prevent pots from boiling over by placing a wooden spoon across the top—a simple trick that avoids messy spills. Need softened butter fast? Grating cold butter or microwaving it in short bursts will give you spreadable butter in no time. These small kitchen tips can greatly improve efficiency and reduce stress while cooking.</p>',
 'uploads/blogs/thumbnails/kitchen-hacks.jpg',
 'uploads/blogs/banners/kitchen-hacks.jpg',
 '2024-08-15 10:00:00'),

('budget-friendly-bites', 'Budget-Friendly Bites', 'Jonathan Melu',
 'Who says healthy eating has to break the bank? Explore a variety of budget-friendly recipes that are both nutritious and satisfying. From pantry staples to seasonal produce, learn how to create delicious meals without sacrificing flavor or quality.',
 '<p>Eating healthy on a budget is entirely possible with the right strategies and recipes. Start by focusing on pantry staples like rice, beans, pasta, and canned tomatoes—these ingredients are affordable, versatile, and can form the base of countless nutritious meals. Buying seasonal produce is another great way to save money while enjoying fresh, flavorful ingredients. Vegetables like carrots, cabbage, and potatoes are often inexpensive and packed with nutrients.</p><p>Meal planning and batch cooking can also help you maximize your grocery budget. Preparing large portions of soups, stews, or casseroles allows you to enjoy multiple meals from a single cooking session, reducing both time and cost. Don''t overlook frozen vegetables and fruits—they''re just as nutritious as fresh options and often more affordable. With a little creativity and planning, you can create delicious, healthy meals that won''t strain your wallet.</p>',
 'uploads/blogs/thumbnails/budget-friendly-bites.jpg',
 'uploads/blogs/banners/budget-friendly-bites.jpg',
 '2024-09-01 14:30:00'),

('spice-up-your-life', 'Spice Up Your Life', 'Adrian Esguerra',
 'Embark on a culinary adventure with a global exploration of spices and herbs. Discover the unique flavors and health benefits of ingredients from different cultures.',
 '<p>Spices and herbs are the secret to transforming ordinary dishes into extraordinary culinary experiences. From the warmth of cinnamon to the boldness of cumin, each spice brings its own unique flavor profile and health benefits. For instance, turmeric is known for its anti-inflammatory properties, while ginger aids digestion and adds a zesty kick to both sweet and savory dishes.</p><p>Exploring spices from different cultures opens up a world of possibilities in the kitchen. Indian cuisine showcases the complexity of garam masala, while Mexican cooking highlights the smoky depth of chipotle peppers. Middle Eastern dishes often feature sumac and za''atar, adding tangy and earthy notes. By experimenting with various spices and herbs, you can elevate your cooking, discover new favorite flavors, and enjoy the added health benefits these ingredients provide.</p>',
 'uploads/blogs/thumbnails/spice-up-your-life.jpg',
 'uploads/blogs/banners/spice-up-your-life.jpg',
 '2024-09-15 09:45:00'),

('5-ways-healthy-cooking-classes', '5 Ways Healthy Cooking Classes can Help Your Diet', 'Jonathan Melu',
 'Explore how cooking classes can introduce you to healthy eating habits. From learning nutritious recipes to understanding portion control, discover five key benefits.',
 '<p>Healthy cooking classes offer more than just recipes—they provide valuable knowledge and skills that can transform your approach to food. First, they teach you how to prepare nutritious meals using fresh, whole ingredients, helping you move away from processed foods. Second, you''ll learn about portion control and balanced meals, which are essential for maintaining a healthy diet.</p><p>Third, cooking classes often introduce you to new ingredients and cuisines, expanding your culinary repertoire and making healthy eating more exciting. Fourth, they provide a supportive environment where you can ask questions and learn from experienced instructors and fellow participants. Finally, cooking classes empower you to take control of your diet by giving you the confidence and skills to prepare healthy meals at home. Whether you''re a beginner or an experienced cook, these classes can be a game-changer for your health and well-being.</p>',
 'uploads/blogs/thumbnails/5-ways-healthy-cooking.jpg',
 'uploads/blogs/banners/5-ways-healthy-cooking.jpg',
 '2024-10-01 11:20:00');

-- Verify the data was inserted
SELECT id, title, author, created_at FROM blogs;
