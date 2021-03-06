CREATE DATABASE 'greenpharma';
USE [greenpharma]
GO
/****** Object:  Table [dbo].[migrations]    Script Date: 08/01/2021 21:11:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[migrations](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[migration] [nvarchar](255) NOT NULL,
	[batch] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[password_resets]    Script Date: 08/01/2021 21:11:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[password_resets](
	[email] [nvarchar](255) NOT NULL,
	[token] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[product_dates]    Script Date: 08/01/2021 21:11:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[product_dates](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[fk_product] [int] NOT NULL,
	[competence] [date] NOT NULL,
	[valor] [float] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[products]    Script Date: 08/01/2021 21:11:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[products](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[industria] [nvarchar](255) NOT NULL,
	[unidade] [nvarchar](255) NOT NULL,
	[cod] [int] NOT NULL,
	[ean] [bigint] NOT NULL,
	[descrition] [nvarchar](255) NOT NULL,
	[provider] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[users]    Script Date: 08/01/2021 21:11:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[password] [nvarchar](255) NOT NULL,
	[flg_type] [int] NOT NULL,
	[flg_active] [int] NOT NULL,
	[remember_token] [nvarchar](100) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  StoredProcedure [dbo].[pesquisaProdutos]    Script Date: 08/01/2021 21:11:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[pesquisaProdutos] (@inicial as varchar(13),@final as varchar(13),@unidade as varchar(255),@industria as varchar(255))
as
	declare @comp as varchar(255);
	declare @pindustria as varchar(255);
	declare @punidade as varchar(255);
	set @comp = 'competence between '''+@inicial+''' and '''+@final+''' ';
	set @pindustria = 'AND industria = '''+@industria+''' ';
	set @punidade = 'AND unidade = '''+@unidade+''' ';
	declare @colunas_pivot as nvarchar(max), @comando_sql as nvarchar(max) ; 
	set @colunas_pivot = 
		stuff((
			select ',' + quotename(competence) from dbo.product_dates group by competence order by competence for xml path('')),1,1,'' )
	print @colunas_pivot
	set @comando_sql = '
	select * from(
	select pr.cod AS PRODUTO,
			pr.ean AS EAN,
			pr.descrition AS DESCRIÇÃO,
			pr.provider AS FORNECEDOR,fk_product,competence,valor FROM
			dbo.products AS pr
		INNER JOIN dbo.product_dates AS dt
		ON
			(dt.fk_product = pr.id) where '+@comp+' '+@pindustria+' '+@punidade+'
	) p
	PIVOT
	(
	sum(valor) for competence in ('+@colunas_pivot+') 
	) tab order by 1
	'
	print @comando_sql
	EXECUTE sp_executesql @comando_sql

GO
/****** Object:  StoredProcedure [dbo].[pesquisaProdutosQuatidades]    Script Date: 08/01/2021 21:11:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[pesquisaProdutosQuatidades] (@inicial as varchar(13),@final as varchar(13),@unidade as varchar(255),@industria as varchar(255))
as
	declare @comp as varchar(255);
	declare @pindustria as varchar(255);
	declare @punidade as varchar(255);
	set @comp = 'competence between '''+@inicial+''' and '''+@final+''' ';
	set @pindustria = 'AND industria = '''+@industria+''' ';
	set @punidade = 'AND unidade = '''+@unidade+''' ';
	declare @colunas_pivot as nvarchar(max), @comando_sql as nvarchar(max) ; 
	set @colunas_pivot = 
		stuff((
			select ',' + quotename(competence) from dbo.product_dates group by competence order by competence for xml path('')),1,1,'' )
	print @colunas_pivot
	set @comando_sql = '
	select * from(
	select pr.cod AS PRODUTO,
			pr.ean AS EAN,
			pr.descrition AS DESCRIÇÃO,
			pr.provider AS FORNECEDOR,
			competence,
			
			count(valor) as valor
			FROM
			dbo.products AS pr
		INNER JOIN dbo.product_dates AS dt
		ON
			(dt.fk_product = pr.id) where '+@comp+' '+@pindustria+' '+@punidade+'  group by pr.cod, pr.ean, pr.descrition, pr.provider, competence, valor
	) p
	PIVOT
	(
	sum(valor) for competence in ('+@colunas_pivot+') 
	) tab order by 1
	'
	print @comando_sql
	EXECUTE sp_executesql @comando_sql
GO
