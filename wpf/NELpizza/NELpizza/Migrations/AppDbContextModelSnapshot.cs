﻿// <auto-generated />
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Infrastructure;
using Microsoft.EntityFrameworkCore.Storage.ValueConversion;
using NELpizza.Databases;

#nullable disable

namespace NELpizza.Migrations
{
    [DbContext(typeof(AppDbContext))]
    partial class AppDbContextModelSnapshot : ModelSnapshot
    {
        protected override void BuildModel(ModelBuilder modelBuilder)
        {
#pragma warning disable 612, 618
            modelBuilder
                .HasAnnotation("ProductVersion", "8.0.10")
                .HasAnnotation("Relational:MaxIdentifierLength", 64);

            modelBuilder.Entity("NELpizza.Model.BlockType", b =>
                {
                    b.Property<int>("BlockTypeID")
                        .ValueGeneratedOnAdd()
                        .HasColumnType("int");

                    b.Property<string>("Name")
                        .IsRequired()
                        .HasMaxLength(50)
                        .HasColumnType("varchar(50)");

                    b.HasKey("BlockTypeID");

                    b.ToTable("BlockTypes");
                });

            modelBuilder.Entity("NELpizza.Model.CustomModelData", b =>
                {
                    b.Property<int>("CustomModelDataID")
                        .ValueGeneratedOnAdd()
                        .HasColumnType("int");

                    b.Property<int>("CustomModelNumber")
                        .HasColumnType("int");

                    b.Property<string>("ModelPath")
                        .IsRequired()
                        .HasMaxLength(255)
                        .HasColumnType("varchar(255)");

                    b.Property<string>("Name")
                        .IsRequired()
                        .HasMaxLength(100)
                        .HasColumnType("varchar(100)");

                    b.Property<int>("ParentItemID")
                        .HasColumnType("int");

                    b.Property<bool>("Status")
                        .HasColumnType("tinyint(1)");

                    b.HasKey("CustomModelDataID");

                    b.HasIndex("ParentItemID");

                    b.ToTable("CustomModelDataItems");
                });

            modelBuilder.Entity("NELpizza.Model.CustomModel_BlockType", b =>
                {
                    b.Property<int>("CustomModelDataID")
                        .HasColumnType("int");

                    b.Property<int>("BlockTypeID")
                        .HasColumnType("int");

                    b.HasKey("CustomModelDataID", "BlockTypeID");

                    b.HasIndex("BlockTypeID");

                    b.ToTable("CustomModel_BlockType");
                });

            modelBuilder.Entity("NELpizza.Model.CustomModel_ShaderArmor", b =>
                {
                    b.Property<int>("CustomModelDataID")
                        .HasColumnType("int");

                    b.Property<int>("ShaderArmorColorInfoID")
                        .HasColumnType("int");

                    b.HasKey("CustomModelDataID", "ShaderArmorColorInfoID");

                    b.HasIndex("ShaderArmorColorInfoID");

                    b.ToTable("CustomModel_ShaderArmor");
                });

            modelBuilder.Entity("NELpizza.Model.CustomVariation", b =>
                {
                    b.Property<int>("CustomVariationID")
                        .ValueGeneratedOnAdd()
                        .HasColumnType("int");

                    b.Property<string>("BlockData")
                        .IsRequired()
                        .HasMaxLength(255)
                        .HasColumnType("varchar(255)");

                    b.Property<int>("BlockTypeID")
                        .HasColumnType("int");

                    b.Property<int>("CustomModelDataID")
                        .HasColumnType("int");

                    b.Property<int>("Variation")
                        .HasColumnType("int");

                    b.HasKey("CustomVariationID");

                    b.HasIndex("BlockTypeID");

                    b.HasIndex("CustomModelDataID");

                    b.ToTable("CustomVariations");
                });

            modelBuilder.Entity("NELpizza.Model.ParentItem", b =>
                {
                    b.Property<int>("ParentItemID")
                        .ValueGeneratedOnAdd()
                        .HasColumnType("int");

                    b.Property<string>("Name")
                        .IsRequired()
                        .HasMaxLength(100)
                        .HasColumnType("varchar(100)");

                    b.Property<string>("Type")
                        .IsRequired()
                        .HasMaxLength(50)
                        .HasColumnType("varchar(50)");

                    b.HasKey("ParentItemID");

                    b.ToTable("ParentItems");
                });

            modelBuilder.Entity("NELpizza.Model.ShaderArmorColorInfo", b =>
                {
                    b.Property<int>("ShaderArmorColorInfoID")
                        .ValueGeneratedOnAdd()
                        .HasColumnType("int");

                    b.Property<int>("Color")
                        .HasColumnType("int");

                    b.Property<string>("HEX")
                        .IsRequired()
                        .HasMaxLength(7)
                        .HasColumnType("varchar(7)");

                    b.Property<string>("Name")
                        .IsRequired()
                        .HasMaxLength(100)
                        .HasColumnType("varchar(100)");

                    b.Property<string>("RGB")
                        .IsRequired()
                        .HasMaxLength(11)
                        .HasColumnType("varchar(11)");

                    b.HasKey("ShaderArmorColorInfoID");

                    b.ToTable("ShaderArmorColorInfos");
                });

            modelBuilder.Entity("NELpizza.Model.CustomModelData", b =>
                {
                    b.HasOne("NELpizza.Model.ParentItem", "ParentItem")
                        .WithMany("CustomModelDataItems")
                        .HasForeignKey("ParentItemID")
                        .OnDelete(DeleteBehavior.Cascade)
                        .IsRequired();

                    b.Navigation("ParentItem");
                });

            modelBuilder.Entity("NELpizza.Model.CustomModel_BlockType", b =>
                {
                    b.HasOne("NELpizza.Model.BlockType", "BlockType")
                        .WithMany("CustomModelDataItems")
                        .HasForeignKey("BlockTypeID")
                        .OnDelete(DeleteBehavior.Cascade)
                        .IsRequired();

                    b.HasOne("NELpizza.Model.CustomModelData", "CustomModelData")
                        .WithMany("BlockTypes")
                        .HasForeignKey("CustomModelDataID")
                        .OnDelete(DeleteBehavior.Cascade)
                        .IsRequired();

                    b.Navigation("BlockType");

                    b.Navigation("CustomModelData");
                });

            modelBuilder.Entity("NELpizza.Model.CustomModel_ShaderArmor", b =>
                {
                    b.HasOne("NELpizza.Model.CustomModelData", "CustomModelData")
                        .WithMany("ShaderArmors")
                        .HasForeignKey("CustomModelDataID")
                        .OnDelete(DeleteBehavior.Cascade)
                        .IsRequired();

                    b.HasOne("NELpizza.Model.ShaderArmorColorInfo", "ShaderArmorColorInfo")
                        .WithMany("CustomModelDataItems")
                        .HasForeignKey("ShaderArmorColorInfoID")
                        .OnDelete(DeleteBehavior.Cascade)
                        .IsRequired();

                    b.Navigation("CustomModelData");

                    b.Navigation("ShaderArmorColorInfo");
                });

            modelBuilder.Entity("NELpizza.Model.CustomVariation", b =>
                {
                    b.HasOne("NELpizza.Model.BlockType", "BlockType")
                        .WithMany("CustomVariations")
                        .HasForeignKey("BlockTypeID")
                        .OnDelete(DeleteBehavior.Cascade)
                        .IsRequired();

                    b.HasOne("NELpizza.Model.CustomModelData", "CustomModelData")
                        .WithMany("CustomVariations")
                        .HasForeignKey("CustomModelDataID")
                        .OnDelete(DeleteBehavior.Cascade)
                        .IsRequired();

                    b.Navigation("BlockType");

                    b.Navigation("CustomModelData");
                });

            modelBuilder.Entity("NELpizza.Model.BlockType", b =>
                {
                    b.Navigation("CustomModelDataItems");

                    b.Navigation("CustomVariations");
                });

            modelBuilder.Entity("NELpizza.Model.CustomModelData", b =>
                {
                    b.Navigation("BlockTypes");

                    b.Navigation("CustomVariations");

                    b.Navigation("ShaderArmors");
                });

            modelBuilder.Entity("NELpizza.Model.ParentItem", b =>
                {
                    b.Navigation("CustomModelDataItems");
                });

            modelBuilder.Entity("NELpizza.Model.ShaderArmorColorInfo", b =>
                {
                    b.Navigation("CustomModelDataItems");
                });
#pragma warning restore 612, 618
        }
    }
}
