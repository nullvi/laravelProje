<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin kullanıcısı oluştur
        $this->createAdmin();

        // Otel yöneticisi oluştur
        $this->createHotelManager();

        // Müşteri oluştur
        $this->createCustomer();
    }

    /**
     * Admin kullanıcısı oluştur
     */
    private function createAdmin(): void
    {
        $adminExists = User::where('email', 'admin@otelrezervasyon.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Sistem Yöneticisi',
                'email' => 'admin@otelrezervasyon.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_approved' => true,
                'phone' => '+90 555 000 01 01',
                'address' => 'Sistem Yönetim Merkezi, İstanbul',
            ]);

            $this->command->info('✅ Admin kullanıcısı oluşturuldu: admin@otelrezervasyon.com (şifre: admin123)');
        } else {
            $this->command->info('ℹ️  Admin kullanıcısı zaten mevcut.');
        }
    }

    /**
     * Otel yöneticisi oluştur
     */
    private function createHotelManager(): void
    {
        $managerExists = User::where('email', 'manager@otelrezervasyon.com')->exists();

        if (!$managerExists) {
            User::create([
                'name' => 'Ahmet Yılmaz',
                'email' => 'manager@otelrezervasyon.com',
                'password' => Hash::make('manager123'),
                'role' => 'hotel_manager',
                'is_approved' => true,
                'phone' => '+90 555 000 02 02',
                'address' => 'Taksim Meydan, Beyoğlu/İstanbul',
            ]);

            $this->command->info('✅ Otel yöneticisi oluşturuldu: manager@otelrezervasyon.com (şifre: manager123)');
        } else {
            $this->command->info('ℹ️  Otel yöneticisi zaten mevcut.');
        }
    }

    /**
     * Müşteri oluştur
     */
    private function createCustomer(): void
    {
        $customerExists = User::where('email', 'customer@otelrezervasyon.com')->exists();

        if (!$customerExists) {
            User::create([
                'name' => 'Ayşe Demir',
                'email' => 'customer@otelrezervasyon.com',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
                'is_approved' => true,
                'phone' => '+90 555 000 03 03',
                'address' => 'Kadıköy Moda, İstanbul',
            ]);

            $this->command->info('✅ Müşteri oluşturuldu: customer@otelrezervasyon.com (şifre: customer123)');
        } else {
            $this->command->info('ℹ️  Müşteri zaten mevcut.');
        }
    }
}
