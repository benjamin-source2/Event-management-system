<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\AppNotification;
use App\Models\FavoriteEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->createAdminUser();
        $this->createEventManagers();
        $this->createSampleUsers();
        $this->createSampleEvents();
        $this->createSampleInvitations();
        $this->createSampleNotifications();
    }

    private function createAdminUser(): void
    {
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@eventhub.rw',
            'phone' => '+250788000001',
            'password' => Hash::make('Admin@123456'),
            'role' => 'super_admin',
            'language' => 'en',
            'theme_preference' => 'dark',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created: admin@eventhub.rw / Admin@123456');
    }

    private function createEventManagers(): void
    {
        $managers = [
            [
                'name' => 'Alice Mugisha',
                'username' => 'alice_mugisha',
                'first_name' => 'Alice',
                'last_name' => 'Mugisha',
                'email' => 'alice@eventhub.rw',
            ],
            [
                'name' => 'Jean Baptiste',
                'username' => 'jean_baptiste',
                'first_name' => 'Jean',
                'last_name' => 'Baptiste',
                'email' => 'jean@eventhub.rw',
            ],
        ];

        foreach ($managers as $manager) {
            User::create(array_merge($manager, [
                'phone' => '+2507880000' . str_pad((string) random_int(10, 99), 2, '0', STR_PAD_LEFT),
                'password' => Hash::make('Manager@123456'),
                'role' => 'event_manager',
                'language' => 'en',
                'theme_preference' => 'light',
                'status' => 'active',
                'email_verified_at' => now(),
            ]));
        }

        $this->command->info('Event managers created.');
    }

    private function createSampleUsers(): void
    {
        $users = [
            ['name' => 'Diane Uwimana', 'username' => 'diane_uwimana', 'first_name' => 'Diane', 'last_name' => 'Uwimana', 'email' => 'diane@example.rw'],
            ['name' => 'Eric Habimana', 'username' => 'eric_habimana', 'first_name' => 'Eric', 'last_name' => 'Habimana', 'email' => 'eric@example.rw'],
            ['name' => 'Grace Niyonzima', 'username' => 'grace_niyo', 'first_name' => 'Grace', 'last_name' => 'Niyonzima', 'email' => 'grace@example.rw'],
            ['name' => 'Patrick Kagame', 'username' => 'patrick_kagame', 'first_name' => 'Patrick', 'last_name' => 'Kagame', 'email' => 'patrick@example.rw'],
            ['name' => 'Sandrine Uwase', 'username' => 'sandrine_uwase', 'first_name' => 'Sandrine', 'last_name' => 'Uwase', 'email' => 'sandrine@example.rw'],
            ['name' => 'David Nshimiyimana', 'username' => 'david_nshimi', 'first_name' => 'David', 'last_name' => 'Nshimiyimana', 'email' => 'david@example.rw'],
            ['name' => 'Esther Mukamana', 'username' => 'esther_muka', 'first_name' => 'Esther', 'last_name' => 'Mukamana', 'email' => 'esther@example.rw'],
            ['name' => 'Felix Bizimana', 'username' => 'felix_bizimana', 'first_name' => 'Felix', 'last_name' => 'Bizimana', 'email' => 'felix@example.rw'],
        ];

        foreach ($users as $user) {
            User::create(array_merge($user, [
                'phone' => '+250788' . str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT),
                'password' => Hash::make('User@123456'),
                'role' => 'user',
                'language' => ['en', 'fr', 'rw'][array_rand(['en', 'fr', 'rw'])],
                'theme_preference' => ['light', 'dark'][array_rand(['light', 'dark'])],
                'status' => 'active',
                'email_verified_at' => now(),
            ]));
        }

        $this->command->info('Sample users created.');
    }

    private function createSampleEvents(): void
    {
        $events = [
            [
                'title' => 'Kigali International Tech Summit 2026',
                'description' => 'Join the biggest technology conference in Rwanda featuring global speakers, workshops on AI, blockchain, and cloud computing. Network with industry leaders and explore the future of tech in Africa.',
                'category' => 'technology',
                'location' => 'Kigali Convention Centre',
                'province' => 'kigali',
                'district' => 'Nyarugenge',
                'event_date' => now()->addDays(30),
                'start_time' => '08:00',
                'end_time' => '18:00',
                'ticket_limit' => 1000,
                'organizer_id' => 2,
                'status' => 'approved',
                'featured' => true,
            ],
            [
                'title' => 'Rwanda Innovation Expo',
                'description' => 'Discover groundbreaking innovations from Rwandan entrepreneurs and startups. This expo showcases the best of Rwandan creativity and technological advancement.',
                'category' => 'conference',
                'location' => 'BK Arena',
                'province' => 'kigali',
                'district' => 'Gasabo',
                'event_date' => now()->addDays(15),
                'start_time' => '09:00',
                'end_time' => '17:00',
                'ticket_limit' => 500,
                'organizer_id' => 2,
                'status' => 'approved',
                'featured' => true,
            ],
            [
                'title' => 'Traditional Wedding: Mugisha & Uwimana',
                'description' => 'A beautiful traditional Rwandan wedding ceremony uniting two families. Experience the rich cultural heritage of Rwanda with traditional music, dance, and cuisine.',
                'category' => 'wedding',
                'location' => 'Serena Hotel Kigali',
                'province' => 'kigali',
                'district' => 'Kicukiro',
                'event_date' => now()->addDays(45),
                'start_time' => '14:00',
                'end_time' => '22:00',
                'ticket_limit' => 200,
                'organizer_id' => 3,
                'status' => 'approved',
                'featured' => false,
            ],
            [
                'title' => 'Afrobeats Night: Live in Kigali',
                'description' => 'An electrifying night of Afrobeats music featuring top Rwandan and regional artists. Dance the night away under the stars at this unforgettable musical experience.',
                'category' => 'music',
                'location' => 'Camp Kigali',
                'province' => 'kigali',
                'district' => 'Nyarugenge',
                'event_date' => now()->addDays(20),
                'start_time' => '19:00',
                'end_time' => '02:00',
                'ticket_limit' => 800,
                'organizer_id' => 2,
                'status' => 'approved',
                'featured' => true,
            ],
            [
                'title' => 'Youth Leadership Conference',
                'description' => 'Empowering the next generation of Rwandan leaders. Workshops on leadership, entrepreneurship, and community development by renowned speakers.',
                'category' => 'conference',
                'location' => 'University of Rwanda',
                'province' => 'kigali',
                'district' => 'Gasabo',
                'event_date' => now()->addDays(60),
                'start_time' => '08:00',
                'end_time' => '17:00',
                'ticket_limit' => 300,
                'organizer_id' => 3,
                'status' => 'approved',
                'featured' => false,
            ],
            [
                'title' => 'Lake Kivu Business Retreat',
                'description' => 'A premium networking retreat for business leaders and entrepreneurs at the beautiful Lake Kivu. Combine strategy sessions with relaxation in a stunning setting.',
                'category' => 'business',
                'location' => 'Lake Kivu Serena Hotel',
                'province' => 'western',
                'district' => 'Rubavu',
                'event_date' => now()->addDays(25),
                'start_time' => '09:00',
                'end_time' => '20:00',
                'ticket_limit' => 100,
                'organizer_id' => 2,
                'status' => 'approved',
                'featured' => true,
            ],
            [
                'title' => 'Nyagatare Agricultural Fair',
                'description' => 'Showcasing the best of Rwandan agriculture. Livestock exhibitions, crop displays, farming technology demonstrations, and networking opportunities.',
                'category' => 'other',
                'location' => 'Nyagatare Stadium',
                'province' => 'eastern',
                'district' => 'Nyagatare',
                'event_date' => now()->addDays(35),
                'start_time' => '07:00',
                'end_time' => '18:00',
                'ticket_limit' => 500,
                'organizer_id' => 3,
                'status' => 'approved',
                'featured' => false,
            ],
            [
                'title' => 'Christmas Charity Gala',
                'description' => 'A festive charity gala to support underprivileged children in Rwanda. Enjoy dinner, entertainment, and auctions for a great cause.',
                'category' => 'vip',
                'location' => 'Kigali Marriott Hotel',
                'province' => 'kigali',
                'district' => 'Nyarugenge',
                'event_date' => now()->addDays(90),
                'start_time' => '18:00',
                'end_time' => '23:00',
                'ticket_limit' => 150,
                'organizer_id' => 2,
                'status' => 'approved',
                'featured' => false,
            ],
            [
                'title' => 'School STEM Competition Finals',
                'description' => 'The grand finale of the national STEM competition for secondary schools. Watch young Rwandan innovators showcase their projects.',
                'category' => 'school',
                'location' => 'Kigali Public Library',
                'province' => 'kigali',
                'district' => 'Gasabo',
                'event_date' => now()->addDays(10),
                'start_time' => '09:00',
                'end_time' => '16:00',
                'ticket_limit' => 200,
                'organizer_id' => 3,
                'status' => 'approved',
                'featured' => false,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }

        $this->command->info('Sample events created.');
    }

    private function createSampleInvitations(): void
    {
        $users = User::where('role', 'user')->get();
        $events = Event::all();

        foreach ($users as $index => $user) {
            // Each user requests invitation to 1-3 events
            $numInvitations = min(3, $events->count());
            for ($i = 0; $i < $numInvitations; $i++) {
                $eventIndex = ($index + $i) % $events->count();
                $event = $events[$eventIndex];

                $status = match (true) {
                    $i === 0 => 'approved',
                    $i === 1 => 'pending',
                    default => 'rejected',
                };

                $invitation = Invitation::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                    'approval_status' => $status,
                    'approved_by' => $status === 'approved' ? 1 : null,
                    'verified_at' => $status === 'approved' ? now() : null,
                ]);

                if ($status === 'approved') {
                    // Generate a simple QR code placeholder
                    $qrData = json_encode([
                        'invitation_code' => $invitation->invitation_code,
                        'event_id' => $event->id,
                        'user_id' => $user->id,
                    ]);
                    $invitation->update(['qr_code' => base64_encode($qrData)]);
                }
            }
        }

        $this->command->info('Sample invitations created.');
    }

    private function createSampleNotifications(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            AppNotification::create([
                'user_id' => $user->id,
                'title' => 'Welcome to Rwanda EventHub!',
                'message' => 'Welcome to the platform! Start exploring events and requesting invitations today.',
                'type' => 'success',
                'icon' => 'check-circle',
                'is_read' => false,
            ]);

            if ($user->role === 'super_admin' || $user->role === 'event_manager') {
                AppNotification::create([
                    'user_id' => $user->id,
                    'title' => 'New Events Pending',
                    'message' => 'There are new events waiting for your review and approval.',
                    'type' => 'info',
                    'icon' => 'calendar',
                    'is_read' => false,
                ]);
            }
        }

        $this->command->info('Sample notifications created.');
        $this->command->info('');
        $this->command->info('====================================');
        $this->command->info('  Rwanda EventHub is ready!');
        $this->command->info('====================================');
        $this->command->info('  Admin: admin@eventhub.rw / Admin@123456');
        $this->command->info('  Manager: alice@eventhub.rw / Manager@123456');
        $this->command->info('  Users: diane@example.rw / User@123456');
        $this->command->info('====================================');
    }
}
