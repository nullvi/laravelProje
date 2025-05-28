<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--role=customer : Kullanıcı rolü (admin, hotel_manager, customer)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yeni kullanıcı oluşturur (admin, otel yöneticisi veya müşteri)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏨 Otel Rezervasyon Sistemi - Kullanıcı Oluşturucu');
        $this->info('===============================================');

        // Rol seçimi
        $role = $this->option('role');
        if (!in_array($role, ['admin', 'hotel_manager', 'customer'])) {
            $role = $this->choice(
                'Kullanıcı rolünü seçin:',
                ['admin' => 'Admin', 'hotel_manager' => 'Otel Yöneticisi', 'customer' => 'Müşteri'],
                'customer'
            );
        }

        // Kullanıcı bilgilerini al
        $name = $this->ask('Ad Soyad');
        $email = $this->ask('E-posta');
        $password = $this->secret('Şifre (en az 6 karakter)');
        $phone = $this->ask('Telefon (opsiyonel)', null);
        $address = $this->ask('Adres (opsiyonel)', null);

        // Validasyon
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $this->error('❌ Hata:');
            foreach ($validator->errors()->all() as $error) {
                $this->line("   • $error");
            }
            return 1;
        }

        // Onay için admin olan kullanıcıları otomatik onayla
        $isApproved = ($role === 'admin') ? true : $this->confirm('Kullanıcı onaylı mı?', true);

        try {
            // Kullanıcı oluştur
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
                'is_approved' => $isApproved,
                'phone' => $phone,
                'address' => $address,
            ]);

            $this->newLine();
            $this->info('✅ Kullanıcı başarıyla oluşturuldu!');
            $this->table(
                ['Alan', 'Değer'],
                [
                    ['ID', $user->id],
                    ['Ad Soyad', $user->name],
                    ['E-posta', $user->email],
                    ['Rol', $this->getRoleDisplayName($user->role)],
                    ['Onaylandı', $user->is_approved ? 'Evet' : 'Hayır'],
                    ['Telefon', $user->phone ?: 'Belirtilmedi'],
                    ['Adres', $user->address ?: 'Belirtilmedi'],
                ]
            );

        } catch (\Exception $e) {
            $this->error('❌ Kullanıcı oluşturulurken hata: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Rol adını Türkçe olarak döndür
     */
    private function getRoleDisplayName($role): string
    {
        return match($role) {
            'admin' => 'Admin',
            'hotel_manager' => 'Otel Yöneticisi',
            'customer' => 'Müşteri',
            default => $role,
        };
    }
}
